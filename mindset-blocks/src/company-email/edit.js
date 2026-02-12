/**
 * Retrieves the translation of text.
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * Block editor utilities for props, rendering, and controls.
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/
 */
import { 
	useBlockProps, 
	RichText, 
	InspectorControls 
} from '@wordpress/block-editor';

/**
 * WordPress core data utilities.
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-core-data/
 */
import { useEntityProp } from '@wordpress/core-data';

/**
 * WordPress UI components for block settings.
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/
 */
import { 
	PanelBody, 
	PanelRow, 
	ToggleControl 
} from '@wordpress/components';

/**
 * Edit function - defines block structure in the editor.
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 */
export default function Edit( { attributes, setAttributes } ) {
	
	// Set the post ID of your Contact Page
	const postID = 15;
	
	// Fetch meta data as an object and the setMeta function
	const [ meta, setMeta ] = useEntityProp( 'postType', 'page', 'meta', postID );
	
	// Destructure meta data
	const { company_email } = meta;
	
	// Helper for setting a single meta value without mutating state
	const updateMeta = ( key, value ) => {
		setMeta( { ...meta, [ key ]: value } );
	};
	
	const { svgIcon } = attributes;
	
	return (
		<>
			<address { ...useBlockProps() }>
				{ svgIcon && 
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" role="img" aria-label="Email icon">
			<path d="M24 0l-6 22-8.129-7.239 7.802-8.234-10.458 7.227-7.215-1.754 24-12zm-15 16.668v7.332l3.258-4.431-3.258-2.901z"></path>
		</svg>
				}
				<RichText
					placeholder={ __( 'Enter email here...', 'company-email' ) }
					tagName="p"
					value={ company_email }
					onChange={ ( nextValue ) => updateMeta( 'company_email', nextValue ) }
				/>
			</address>
			
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'company-email' ) }>
					<PanelRow>
						<ToggleControl
							label={ __( 'Show SVG Icon', 'company-email' ) }
							checked={ svgIcon }
							onChange={ ( value ) => setAttributes( { svgIcon: value } ) }
							help={ __( 'Display an SVG icon next to the email.', 'company-email' ) }
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>
		</>
	);
}