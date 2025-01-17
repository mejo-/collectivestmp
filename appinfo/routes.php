<?php
/**
 * Nextcloud - Collectives
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 */

return [
	'routes' => [
		// collectives API
		['name' => 'collective#index', 'url' => '/_api', 'verb' => 'GET'],
		['name' => 'collective#create', 'url' => '/_api', 'verb' => 'POST'],
		['name' => 'collective#update', 'url' => '/_api/{id}', 'verb' => 'PUT',
			'requirements' => ['id' => '\d+']],
		['name' => 'collective#editLevel', 'url' => '/_api/{id}/editLevel', 'verb' => 'PUT',
			'requirements' => ['id' => '\d+']],
		['name' => 'collective#shareLevel', 'url' => '/_api/{id}/shareLevel', 'verb' => 'PUT',
			'requirements' => ['id' => '\d+']],
		['name' => 'collective#pageMode', 'url' => '/_api/{id}/pageMode', 'verb' => 'PUT',
			'requirements' => ['id' => '\d+']],
		['name' => 'collective#trash', 'url' => '/_api/{id}', 'verb' => 'DELETE',
			'requirements' => ['id' => '\d+']],
		['name' => 'collective#createShare', 'url' => '/_api/{id}/share', 'verb' => 'POST',
			'requirements' => ['id' => '\d+']],
		['name' => 'collective#updateShare', 'url' => '/_api/{id}/share/{token}', 'verb' => 'PUT',
			'requirements' => ['id' => '\d+']],
		['name' => 'collective#deleteShare', 'url' => '/_api/{id}/share/{token}', 'verb' => 'DELETE',
			'requirements' => ['id' => '\d+']],

		// collectives trash API
		['name' => 'trash#index', 'url' => '/_api/trash', 'verb' => 'GET'],
		['name' => 'trash#delete', 'url' => '/_api/trash/{id}', 'verb' => 'DELETE',
			'requirements' => ['id' => '\d+']],
		['name' => 'trash#restore', 'url' => '/_api/trash/{id}', 'verb' => 'PATCH',
			'requirements' => ['id' => '\d+']],

		// collectives userSettings API
		['name' => 'collectiveUserSettings#pageOrder', 'url' => '/_api/{id}/_userSettings/pageOrder', 'verb' => 'PUT',
			'requirements' => ['id' => '\d+']],

		// pages API
		['name' => 'page#index', 'url' => '/_api/{collectiveId}/_pages',
			'verb' => 'GET', 'requirements' => ['collectiveId' => '\d+']],
		['name' => 'page#get', 'url' => '/_api/{collectiveId}/_pages/parent/{parentId}/page/{id}',
			'verb' => 'GET', 'requirements' => ['collectiveId' => '\d+', 'parentId' => '\d+', 'id' => '\d+']],
		['name' => 'page#create', 'url' => '/_api/{collectiveId}/_pages/parent/{parentId}',
			'verb' => 'POST', 'requirements' => ['collectiveId' => '\d+', 'parentId' => '\d+']],
		['name' => 'page#touch', 'url' => '/_api/{collectiveId}/_pages/parent/{parentId}/page/{id}/touch',
			'verb' => 'GET', 'requirements' => ['collectiveId' => '\d+', 'parentId' => '\d+', 'id' => '\d+']],
		['name' => 'page#rename', 'url' => '/_api/{collectiveId}/_pages/parent/{parentId}/page/{id}',
			'verb' => 'PUT', 'requirements' => ['collectiveId' => '\d+', 'parentId' => '\d+', 'id' => '\d+']],
		['name' => 'page#setEmoji', 'url' => '/_api/{collectiveId}/_pages/parent/{parentId}/page/{id}/emoji',
			'verb' => 'PUT', 'requirements' => ['collectiveId' => '\d+', 'parentId' => '\d+', 'id' => '\d+']],
		['name' => 'page#setSubpageOrder', 'url' => '/_api/{collectiveId}/_pages/parent/{parentId}/page/{id}/subpageOrder',
			'verb' => 'PUT', 'requirements' => ['collectiveId' => '\d+', 'parentId' => '\d+', 'id' => '\d+']],
		['name' => 'page#delete', 'url' => '/_api/{collectiveId}/_pages/parent/{parentId}/page/{id}',
			'verb' => 'DELETE', 'requirements' => ['collectiveId' => '\d+', 'parentId' => '\d+', 'id' => '\d+']],
		['name' => 'page#getBacklinks', 'url' => '/_api/{collectiveId}/_pages/parent/{parentId}/page/{id}/backlinks',
			'verb' => 'GET', 'requirements' => ['collectiveId' => '\d+', 'parentId' => '\d+', 'id' => '\d+']],
		['name' => 'page#getAttachments', 'url' => '/_api/{collectiveId}/_pages/parent/{parentId}/page/{id}/attachments',
			'verb' => 'GET', 'requirements' => ['collectiveId' => '\d+', 'parentId' => '\d+', 'id' => '\d+']],

		// public collectives API
		['name' => 'publicCollective#get', 'url' => '/_api/p/{token}', 'verb' => 'GET'],

		// public pages API
		['name' => 'publicPage#index', 'url' => '/_api/p/{token}/_pages', 'verb' => 'GET'],
		['name' => 'publicPage#get', 'url' => '/_api/p/{token}/_pages/parent/{parentId}/page/{id}',
			'verb' => 'GET', 'requirements' => ['parentId' => '\d+', 'id' => '\d+']],
		['name' => 'publicPage#create', 'url' => '/_api/p/{token}/_pages/parent/{parentId}',
			'verb' => 'POST', 'requirements' => ['parentId' => '\d+']],
		['name' => 'publicPage#touch', 'url' => '/_api/p/{token}/_pages/parent/{parentId}/page/{id}/touch',
			'verb' => 'GET', 'requirements' => ['parentId' => '\d+', 'id' => '\d+']],
		['name' => 'publicPage#rename', 'url' => '/_api/p/{token}/_pages/parent/{parentId}/page/{id}',
			'verb' => 'PUT', 'requirements' => ['parentId' => '\d+', 'id' => '\d+']],
		['name' => 'publicPage#setEmoji', 'url' => '/_api/p/{token}/_pages/parent/{parentId}/page/{id}/emoji',
			'verb' => 'PUT', 'requirements' => ['parentId' => '\d+', 'id' => '\d+']],
		['name' => 'publicPage#setSubpageOrder', 'url' => '/_api/p/{token}/_pages/parent/{parentId}/page/{id}/subpageOrder',
			'verb' => 'PUT', 'requirements' => ['parentId' => '\d+', 'id' => '\d+']],
		['name' => 'publicPage#delete', 'url' => '/_api/p/{token}/_pages/parent/{parentId}/page/{id}',
			'verb' => 'DELETE', 'requirements' => ['parentId' => '\d+', 'id' => '\d+']],
		['name' => 'publicPage#getAttachments', 'url' => '/_api/p/{token}/_pages/parent/{parentId}/page/{id}/attachments',
			'verb' => 'GET', 'requirements' => ['parentId' => '\d+', 'id' => '\d+']],
		['name' => 'publicPage#getBacklinks', 'url' => '/_api/p/{token}/_pages/parent/{parentId}/page/{id}/backlinks',
			'verb' => 'GET', 'requirements' => ['parentId' => '\d+', 'id' => '\d+']],

		// default public route (Vue.js frontend)
		['name' => 'publicStart#publicIndex', 'url' => '/p/{token}/{path}', 'verb' => 'GET',
			'requirements' => ['path' => '.*'],	'defaults' => ['path' => '']],

		// default route (Vue.js frontend)
		['name' => 'start#index', 'url' => '/{path}', 'verb' => 'GET',
			'requirements' => ['path' => '.*'],
			'defaults' => ['path' => '']],
	],
	'ocs' => [
		['name' => 'settings#getUserSetting', 'url' => '/api/v{apiVersion}/settings/user/{key}', 'verb' => 'GET',
			'requirements' => ['apiVersion' => '1.0']],
		['name' => 'settings#setUserSetting', 'url' => '/api/v{apiVersion}/settings/user', 'verb' => 'POST',
			'requirements' => ['apiVersion' => '1.0']],
	]
];
