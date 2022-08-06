import { withSelect, withDispatch } from '@wordpress/data';
import { PanelRow, TextControl } from '@wordpress/components';

const { compose } = wp.compose;
import { __ } from '@wordpress/i18n';

const CustomTitle = ( { postMeta, setPostMeta } ) => {
	return (
		<>
			<PanelRow>
				<div>
					<TextControl
						label={ __( 'Custom title', 'ibn' ) }
						value={ postMeta.ibn_post_custom_title }
						onChange={ ( value ) =>
							// update the post meta
							setPostMeta( { ibn_post_custom_title: value } )
						}
					/>
				</div>
			</PanelRow>
		</>
	);
};

export default compose( [
	withSelect( ( select ) => {
		return {
			// get the post meta
			postMeta: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
		};
	} ),
	withDispatch( ( dispatch ) => {
		return {
			setPostMeta( newMeta ) {
				// handle field update
				dispatch( 'core/editor' ).editPost( { meta: newMeta } );
			},
		};
	} ),
] )( CustomTitle );
