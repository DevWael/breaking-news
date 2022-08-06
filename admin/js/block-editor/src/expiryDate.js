import { withSelect, withDispatch } from '@wordpress/data';
import { PanelRow, DateTimePicker, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';

const { compose } = wp.compose;
const ExpiryDate = ( { postMeta, setPostMeta } ) => {
	const isInvalidDate = ( date ) => {
		return date.getTime() < new Date().getTime();
	};
	return (
		<>
			<PanelRow>
				<ToggleControl
					checked={ postMeta.ibn_post_expiry_date_toggle }
					label={ __( 'Set breaking news expiry date', 'ibn' ) }
					help={ __(
						'After this date, the post will no longer appear in the breaking news bar',
						'ibn'
					) }
					onChange={ ( value ) =>
						setPostMeta( { ibn_post_expiry_date_toggle: value } )
					}
				/>
			</PanelRow>
			{ postMeta.ibn_post_expiry_date_toggle && (
				<PanelRow>
					<div>
						<DateTimePicker
							label={ __( 'Expiry Date', 'ibn' ) }
							currentDate={
								postMeta.ibn_post_expiry_date ?? new Date()
							}
							onChange={ ( value ) =>
								setPostMeta( { ibn_post_expiry_date: value } )
							}
							isInvalidDate={ ( date ) => isInvalidDate( date ) }
							is12Hour={ true }
							__nextRemoveHelpButton
							__nextRemoveResetButton
						/>
					</div>
				</PanelRow>
			) }
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
				console.log( 'setPostMeta', newMeta );
				// handle field update
				dispatch( 'core/editor' ).editPost( { meta: newMeta } );
			},
		};
	} ),
] )( ExpiryDate );
