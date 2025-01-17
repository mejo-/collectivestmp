<template>
	<div id="text-wrapper" class="richEditor">
		<input id="sharingToken"
			type="hidden"
			name="sharingToken"
			:value="shareTokenParam">
		<div id="text" class="editor">
			<PageInfoBar :current-page="currentPage" />
			<NcEmptyContent v-if="loading('pageContent')">
				<template #icon>
					<NcLoadingIcon />
				</template>
			</NcEmptyContent>
			<RichTextReader v-else
				:content="pageContent"
				@click-link="followLink" />
		</div>
	</div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
import { RichTextReader, AttachmentResolver, ATTACHMENT_RESOLVER, OUTLINE_STATE, OUTLINE_ACTIONS } from '@nextcloud/text'
import { getCurrentUser } from '@nextcloud/auth'
import { generateUrl } from '@nextcloud/router'
import { NcEmptyContent, NcLoadingIcon } from '@nextcloud/vue'
import PageInfoBar from './PageInfoBar.vue'

const resolvePath = function(from, rel) {
	if (!rel) {
		return from
	}
	if (rel[0] === '/') {
		return rel
	}
	from = from.split('/')
	from.pop()
	rel = rel.split('/')
	while (rel[0] === '..' || rel[0] === '.') {
		if (rel[0] === '..') {
			from.pop()
		}
		rel.shift()
	}
	return from.concat(rel).join('/')
}

export default {
	name: 'RichText',

	components: {
		NcEmptyContent,
		NcLoadingIcon,
		PageInfoBar,
		RichTextReader,
	},

	provide() {
		const val = {}
		Object.defineProperties(val, {
			[ATTACHMENT_RESOLVER]: { get: () => this.attachmentResolver },
			[OUTLINE_STATE]: { get: () => this.outline },
			[OUTLINE_ACTIONS]: { get: () => ({ toggle: this.toggleOutlineFromTextComponent }) },
		})
		return val
	},

	props: {
		currentPage: {
			type: Object,
			required: true,
		},
		pageContent: {
			type: String,
			default: null,
		},
	},

	data() {
		return {
			outline: {
				visible: false,
				enable: false,
			},
		}
	},

	computed: {
		...mapGetters([
			'collectiveParam',
			'currentCollective',
			'currentPageDirectory',
			'currentPageFilePath',
			'isPublic',
			'loading',
			'pageParam',
			'showing',
			'shareTokenParam',
		]),

		attachmentResolver() {
			return new AttachmentResolver({
				fileId: this.currentPage.id,
				currentDirectory: '/' + this.currentPageDirectory,
				user: getCurrentUser(),
				shareToken: this.shareTokenParam,
			})
		},

		showOutline() {
			return this.showing('outline')
		},
	},

	watch: {
		'showOutline'() {
			this.outline.visible = this.showing('outline')
		},
	},

	methods: {
		...mapMutations([
			'toggle',
		]),

		followLink(_event, attrs) {
			return this.handleCollectiveLink(attrs)
				|| this.handleSameOriginLink(attrs)
				|| this.handleRelativeFileLink(attrs)
				|| window.open(attrs.href, '_blank')
		},

		// E.g. `https://cloud.example.org/apps/collectives/mycollective/...` or `/apps/collectives/mycollective/...`
		handleCollectiveLink({ href }) {
			// Add origin for local links and resolve relative paths
			const full = new URL(href, window.location)
			href = full.href

			const baseUrl = new URL(generateUrl('/apps/collectives'), window.location)
			if (!href.startsWith(baseUrl.href)) {
				// Ignore everything except links to local collectives app
				return false
			}

			// Try to resolve relative links to markdown files
			if (href.includes('.md?fileId=')) {
				// With `fileId` parameter
				href = href.replace('.md?', '?')
			} else if (href.endsWith('.md')) {
				// Without `fileId` parameter
				href = href.slice(0, -'.md'.length)
				if (href.endsWith('/Readme')) {
					href = href.slice(0, -'/Readme'.length)
				}
			}

			let collectivePath = href.replace(baseUrl.href, '')
			const publicPrefix = `/p/${this.currentCollective.shareToken}`

			if (this.isPublic
				&& (collectivePath === `/${encodeURIComponent(this.collectiveParam)}`
					|| collectivePath.startsWith(`/${encodeURIComponent(this.collectiveParam)}/`))) {
				// In public share, rewrite private link to own collective to a public share
				collectivePath = `${publicPrefix}${collectivePath}`
			} else if (!this.isPublic && collectivePath.startsWith(publicPrefix)) {
				// When internal, rewrite link to public share of own collective to private
				collectivePath = collectivePath.replace(publicPrefix, '')
			}

			this.$router.push(collectivePath)
			return true
		},

		// E.g. `https://cloud.example.org/
		handleSameOriginLink({ href }) {
			if (href.match('/^' + window.location.origin + '/')) {
				window.open(href)
			}
		},

		handleRelativeFileLink({ href }) {
			if (!href.match(/^[a-zA-Z]*:/)) {
				const fileIdMatches = href.match(/^([^?]*)\?fileId=(\d+)/)
				if (!fileIdMatches || fileIdMatches.length < 2) {
					// href search params don't contain a fileId
					return false
				}
				const encodedRelPath = fileIdMatches[1]
				const relPath = decodeURI(encodedRelPath)
				const path = resolvePath(`/${this.currentPageFilePath}`, relPath)
				this.OCA.Viewer.open({ path })
				return true
			}
		},

		toggleOutlineFromTextComponent() {
			this.toggle('outline')
		},
	},
}
</script>

<style scoped lang="scss">
@import '~@nextcloud/text/dist/style.css';

#text-wrapper {
	display: flex;
	width: 100%;
	height: 100%;
}

#text-wrapper.icon-loading #editor {
	opacity: 0.3;
}

#text, .editor {
	background: var(--color-main-background);
	color: var(--color-main-text);
	background-clip: padding-box;
	padding: 0;
	position: relative;
	overflow-y: auto;
	overflow-x: hidden;
	width: 100%;
	margin-left: auto;
	margin-right: auto;
	/* Overflow is required for sticky menubar */
	overflow: visible !important;
}

.text-revision {
	background-color: lightcoral;
}
</style>

<style lang="scss">
:root {
	// Required for read-only view where only RichTextReader and no Editor gets loaded
	--text-editor-max-width: 670px;
}

@media print {

	h1, h2, h3 {
		page-break-after: avoid;
	}
}
</style>
