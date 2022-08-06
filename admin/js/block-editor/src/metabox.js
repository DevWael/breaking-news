import {
	ToggleControl,
	PanelRow,
	__experimentalDivider as Divider,
	Placeholder,
	Spinner,
} from '@wordpress/components';
import { dispatch, select, subscribe } from '@wordpress/data';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { Component } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import api from '@wordpress/api';
import CustomTitle from './customTitle';

export default class Metabox extends Component {
	constructor() {
		super( ...arguments );
		this.state = {
			isAPILoaded: false,
			editBreakingNews: false,
			breakingNewsId: '',
		};
	}

	componentDidMount() {
		/**
		 * Subscribe to the post save button to send api request to save the option for the breaking news post id.
		 */
		subscribe( () => {
			const { breakingNewsId, editBreakingNews } = this.state;
			const isSavingPost = select( 'core/editor' ).isSavingPost();
			const isAutosavingPost = select( 'core/editor' ).isAutosavingPost();
			if ( isAutosavingPost ) {
				return; // don't save the breaking news id if it is autosaving
			}
			if ( ! isSavingPost ) {
				return; // don't save if not saving
			}
			if ( editBreakingNews ) {
				// if the post is marked as breaking news (toggle control is checked)
				const settings = new api.models.Settings( {
					ibn_breaking_news_post_id: breakingNewsId,
				} );
				settings.save(); // save the breaking news id
			} else if ( this.isActiveBreakingNews( breakingNewsId ) ) {
				// check if the post is active breaking news (toggle control is not checked)
				const settings = new api.models.Settings( {
					ibn_breaking_news_post_id: 0,
				} );
				settings.save(); // erase the breaking news id
			}
		} );
		api.loadPromise.then( () => {
			this.settings = new api.models.Settings(); // load the settings model
			const { isAPILoaded } = this.state;
			if ( isAPILoaded === false ) {
				this.settings.fetch().then( ( response ) => {
					this.setState( {
						breakingNewsId: response.ibn_breaking_news_post_id, // set the breaking news post id from the response of the settings
						editBreakingNews: this.isActiveBreakingNews(
							response.ibn_breaking_news_post_id // check if the current post is active breaking news to toggle the control to checked
						),
						isAPILoaded: true, // finally set the api loaded to true
					} );
				} );
			}
		} );
	}

	/**
	 * Check if the current post is set active breaking news.
	 * @param optionValue
	 * @returns {boolean}
	 */
	isActiveBreakingNews( optionValue ) {
		const postId = select( 'core/editor' ).getCurrentPostId();
		if ( optionValue ) {
			return parseInt( optionValue ) === postId;
		}
		return false;
	}

	/**
	 * Check if the user toggled the breaking news toggle control to checked so we can update the breaking news post id
	 * Or we can erase the breaking news post id if the current post id is active breaking news.
	 * @param boolResult boolean
	 */
	allowUpdateBreakingNews( boolResult ) {
		this.setState( {
			editBreakingNews: boolResult,
			breakingNewsId: select( 'core/editor' ).getCurrentPostId(),
		} );
	}

	render() {
		const postType = select( 'core/editor' ).getCurrentPostType();
		if ( postType !== 'post' ) {
			// prevent the metabox from showing up on other post types
			return null;
		}
		const { isAPILoaded, editBreakingNews } = this.state;
		if ( ! isAPILoaded ) {
			// display loading spinner if the api is not loaded
			return (
				<Placeholder>
					<Spinner />
				</Placeholder>
			);
		}

		/**
		 * Display the breaking news metabox components.
		 */
		return (
			<PluginDocumentSettingPanel
				name="ibn-breaking-news-metabox"
				title={ __( 'Breaking News Bar Settings', 'ibn' ) }
				icon={ 'none' }
				initialOpen={ true }
			>
				{ /* render the main component (the main toggle)*/ }
				<PanelRow>
					<ToggleControl
						checked={ editBreakingNews }
						label={ __( 'Mark as breaking news', 'ibn' ) }
						onChange={ ( boolResult ) => {
							this.allowUpdateBreakingNews( boolResult );
							// update the post status
							dispatch( 'core/editor' ).editPost( {
								meta: { update_editor: boolResult },
							} );
						} }
					/>
				</PanelRow>
				<Divider />
				{ /* render the custom title component */ }
				<CustomTitle />
			</PluginDocumentSettingPanel>
		);
	}
}
