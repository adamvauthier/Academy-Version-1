/**
 * Internal dependencies
 */
import EmbedControls from '../common/embed-controls';
import EmbedLoading from '../common/embed-loading';
import EmbedPlaceholder from '../common/embed-placeholder';
import Iframe from '../common/Iframe';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;

class WistiaEdit extends Component {
    constructor() {
        super( ...arguments );
        this.switchBackToURLInput = this.switchBackToURLInput.bind( this );
        this.setUrl = this.setUrl.bind( this );
        this.onLoad = this.onLoad.bind( this );
        this.state = {
            editingURL: false,
            url: this.props.attributes.url,
            fetching: true,
            cannotEmbed: false
        };
    }

    onLoad() {
        this.setState({
            fetching: false
        })
    }
    decodeHTMLEntities (str) {
        if(str && typeof str === 'string') {
            // strip script/html tags
            str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
            str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');

        }
        return str;
    }


    setUrl( event ) {
        if ( event ) {
            event.preventDefault();
        }
        const { url } = this.state;
        const { setAttributes } = this.props;
        setAttributes( { url } );
        if(url && ( url.match( /^http[s]?:\/\/(?:www\.)?wistia\.com\/medias/i  ) || url.match( /^http[s]?:\/\/(?:www\.)?fast\/.wistia\.com\/embed\/medias/i.jsonp) ) ) {
            let mediaIdMatches = url.match(/medias(.*)/);
            let mediaId  = mediaIdMatches[1];

            let iframeSrc = '//fast.wistia.net/embed/iframe/' + mediaId;

            this.setState( { editingURL: false, cannotEmbed: false } );
            setAttributes( {iframeSrc: iframeSrc });    
        }
        else {
            this.setState({
                cannotEmbed: true,
                editingURL: true
            })
        }
    }

    switchBackToURLInput() {
        this.setState( { editingURL: true } );
    }
    
    render() {
        const { url, editingURL, fetching, cannotEmbed } = this.state;
        const { iframeSrc } = this.props.attributes;

        const label = __( 'Wistia URL');

        // No preview, or we can't embed the current URL, or we've clicked the edit button.
        if ( !iframeSrc  || editingURL ) {
            return (
                <EmbedPlaceholder
                    label={ label }
                    onSubmit={ this.setUrl }
                    value={ url }
                    cannotEmbed={ cannotEmbed }
                    onChange={ ( event ) => this.setState( { url: event.target.value } ) }
                />
            );
        }
        else {
            return (
                <Fragment>
                    {fetching  ?  <EmbedLoading /> : null}
                    <Iframe src={iframeSrc} onLoad={this.onLoad} style={{ display: fetching ? 'none' : '' }} frameborder="0" width="600" height="330" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" />
                    <EmbedControls
                        showEditButton={ iframeSrc && ! cannotEmbed }
                        switchBackToURLInput={ this.switchBackToURLInput }
                    />  
                </Fragment>
            );
        }
    }
};
export default WistiaEdit;
