import { registerPlugin } from '@wordpress/plugins';
import render from './metabox';

registerPlugin( 'ibn-breaking-news-metabox', {
	icon: 'visibility',
	render,
} );
