# Embed Google Docs Viewer

Embed Google Docs Viewer is a plugin for embedding one or more Google Docs Viewers to Joomla articles. By using Google Docs Viewer it's possible to quickly view documents online without leaving browser. Adding Google Docs Viewer to an article is very simple, just add the url of the document that you want to embed, and that's it! It's also possible to define the size of the document, mode of the reader (preview/edit), border layout and link to the full size document.

## Features

* It's possible to embed one or more Google Docs Viewer within an article.
* Supported formats: .doc, .ppt, .xls, .tif and .pdf.
* Supported Google document formats: document, spreadsheet, presentation, form, drawing and file.
* Set Google Doc Viewer's mode when embedding documents created or stored in Google Docs. Supported modes are default, preview and edit.
* Define the language of the Google Docs Viewer interface when embedding documents that are not stored in Google Docs. List of language codes.
* Define the width and height of the viewer.
* Define the border width, border style and border color.
* Add link to the full screen version.
* Define the link label and link position (above or below the document).
  * `top` => above, `bottom` => below (default)
* Support for HTTP and HTTPS (with Google Docs Viewer only).
* Multilingual features for front-end:
** Use the system language as Google Docs Viewer language (with Google Docs Viewer only).
** Use translatable strings as link label, e.g. {TRANSLATABLE_STRING}.

## Syntax

* {google_docs}document_url{/google_docs}
* {google_docs}document_url|width:200|height:200|border:1|border_style:solid|border_color:#000000{/google_docs}
* {google_docs}document_url|width:200|height:200|link:yes|link_label:Label|link_position:top{/google_docs}
* {google_docs}document_url|link:yes{/google_docs}
* {google_docs}document_url|lang:it{/google_docs}
* {google_docs}document_url|lang:system{/google_docs}
* {google_docs}document_url|https:yes{/google_docs}
* {google_docs}document_url|mode:edit{/google_docs}

### Example

Replace the "document_url" string with the url of the document that you want to view.

```
{google_docs}http://www.example.com/docs/document.pdf{/google_docs}
```

## Multilingual features

The language setting can be used with Google Docs Viewer only, and it doesn't work with documents stored in Google Drive.

In the front-end it's possible to use the system language as a Google Docs Viewer language. In multilingual sites this means that it's enough to set the default language to 'system', and the language of the viewer is set according to the language that the user has chosen. For individual docs the default setting can be overridden by using the 'lang' parameter. Setting the system language for individual docs can be done by setting the 'lang' parameter to 'system'

```
{google_docs}document_url|lang:system{/google_docs}
```

It's also possible to use translatable strings as link label, e.g. {TRANSLATABLE_STRING}.

## Border styles

The default border style can be set in the admin panel, but it can be overridden by using the border_style variable. The following values are supported.

* none
* hidden
* dashed
* dotted
* solid
* double

## Border color

The default border color can be set in the admin panel, but it can be overridden by using the border_color variable. Border color must be given in hexadecimal format. The default value is "#000000".

## Google Docs documents

Supported Google document formats: document, spreadsheet, presentation, form, drawing, file.

If you want to embed a document stored in Google Docs do the following.

1. Sign in to your Goole Docs account.
2. Open the document that you want to embed.
3. Click File -> Publish to the web.
4. Copy the link from the "Document link" field.
5. Paste the link between the google_docs tags.

The above steps don't work with forms. To embed a form do the following.

1. Sign in to your Goole Docs account.
2. Open the form that you want to embed.
3. Click Form -> Go to live form.
4. The form opens in a new tab/window.
5. Copy the URL from the browser's address bar.
6. Paste the URL between the google_docs tags.

## Google Docs Viewer's mode

It's possible to set the Google Doc Viewer's mode when embedding documents created or stored in Google Docs. The mode can be set to default, preview and edit. The output depends on the type of the document as not all the types support all the modes. The default type for the site can be set in the admin panel and it can overridden by using the mode parameter.

The default mode means that the document is embedded in the way suggested by Google Docs Publish to the web function. Preview means preview mode and edit means edit mode. The output depends on the document type and in many cases default and preview modes produce the same output. If the selected mode is not supported by the document type, the default mode is used.

## Base URL

In the admin panel it's possible to define a base URL for the documents, which makes embedding the documents even easier as there's no need to type in the full URL for each document. When the base URL is set, the documents can be embedded by using a relative URL. By default the plugin considers Joomla's install directory's URL as the base URL.

```
Base url: http://www.example.com/docs/
Full URL of the document: http://www.example.com/docs/document.pdf

{google_docs}document.pdf{/google_docs}
```

When the base URL is defined it's still possible to embed documents stored in another locations. In this case you just have to use the full URL of the document.

## Language codes

The default language can be set in the admin panel, but it can be overridden by using the lang variable. When using the lang variable, the code of the selected language must be given as a parameter. Below there's a list of languages supported by Google Docs Viewer.

**NB!** The language setting can be used with Google Docs Viewer only, and it doesn't work with documents stored in Google Docs.

<table>
	<tbody>
		<tr>
			<td>
				<b>Code</b></td>
			<td>
				<b>Language</b></td>
		</tr>
		<tr>
			<td>
				ar</td>
			<td>
				Arabic</td>
		</tr>
		<tr>
			<td>
				eu</td>
			<td>
				Basque</td>
		</tr>
		<tr>
			<td>
				bn</td>
			<td>
				Bengali</td>
		</tr>
		<tr>
			<td>
				bg</td>
			<td>
				Bulgarian</td>
		</tr>
		<tr>
			<td>
				ca</td>
			<td>
				Catalan</td>
		</tr>
		<tr>
			<td>
				zh-CN</td>
			<td>
				Chinese (simplified)</td>
		</tr>
		<tr>
			<td>
				zh-TW</td>
			<td>
				Chinese (traditional)</td>
		</tr>
		<tr>
			<td>
				hr</td>
			<td>
				Croatian</td>
		</tr>
		<tr>
			<td>
				cs</td>
			<td>
				Czech</td>
		</tr>
		<tr>
			<td>
				da</td>
			<td>
				Danish</td>
		</tr>
		<tr>
			<td>
				nl</td>
			<td>
				Dutch</td>
		</tr>
		<tr>
			<td>
				en</td>
			<td>
				English</td>
		</tr>
		<tr>
			<td>
				en-AU</td>
			<td>
				English (Australian)</td>
		</tr>
		<tr>
			<td>
				en-GB</td>
			<td>
				English (Great Britain)</td>
		</tr>
		<tr>
			<td>
				fa</td>
			<td>
				Farsi</td>
		</tr>
		<tr>
			<td>
				fil</td>
			<td>
				Filipino</td>
		</tr>
		<tr>
			<td>
				fi</td>
			<td>
				Finnish</td>
		</tr>
		<tr>
			<td>
				fr</td>
			<td>
				French</td>
		</tr>
		<tr>
			<td>
				gl</td>
			<td>
				Galician</td>
		</tr>
		<tr>
			<td>
				de</td>
			<td>
				German</td>
		</tr>
		<tr>
			<td>
				el</td>
			<td>
				Greek</td>
		</tr>
		<tr>
			<td>
				gu</td>
			<td>
				Gujarati</td>
		</tr>
		<tr>
			<td>
				iw</td>
			<td>
				Hebrew</td>
		</tr>
		<tr>
			<td>
				hi</td>
			<td>
				Hindi</td>
		</tr>
		<tr>
			<td>
				hu</td>
			<td>
				Hungarian</td>
		</tr>
		<tr>
			<td>
				id</td>
			<td>
				Indonesian</td>
		</tr>
		<tr>
			<td>
				it</td>
			<td>
				Italian</td>
		</tr>
		<tr>
			<td>
				ja</td>
			<td>
				Japanese</td>
		</tr>
		<tr>
			<td>
				kn</td>
			<td>
				Kannada</td>
		</tr>
		<tr>
			<td>
				ko</td>
			<td>
				Korean</td>
		</tr>
		<tr>
			<td>
				lv</td>
			<td>
				Latvian</td>
		</tr>
		<tr>
			<td>
				lt</td>
			<td>
				Lithuanian</td>
		</tr>
		<tr>
			<td>
				ml</td>
			<td>
				Malayalam</td>
		</tr>
		<tr>
			<td>
				mr</td>
			<td>
				Marathi</td>
		</tr>
		<tr>
			<td>
				no</td>
			<td>
				Norwegian</td>
		</tr>
		<tr>
			<td>
				nn</td>
			<td>
				Norwegian Nynorsk</td>
		</tr>
		<tr>
			<td>
				or</td>
			<td>
				Oriya</td>
		</tr>
		<tr>
			<td>
				pl</td>
			<td>
				Polish</td>
		</tr>
		<tr>
			<td>
				pt</td>
			<td>
				Portuguese</td>
		</tr>
		<tr>
			<td>
				pt-BR</td>
			<td>
				Portuguese (Brazil)</td>
		</tr>
		<tr>
			<td>
				pt-PT</td>
			<td>
				Portuguese (Portugal)</td>
		</tr>
		<tr>
			<td>
				ro</td>
			<td>
				Romanian</td>
		</tr>
		<tr>
			<td>
				rm</td>
			<td>
				Romansch</td>
		</tr>
		<tr>
			<td>
				ru</td>
			<td>
				Russian</td>
		</tr>
		<tr>
			<td>
				sk</td>
			<td>
				Slovak</td>
		</tr>
		<tr>
			<td>
				sl</td>
			<td>
				Slovenian</td>
		</tr>
		<tr>
			<td>
				sr</td>
			<td>
				Serbian</td>
		</tr>
		<tr>
			<td>
				es</td>
			<td>
				Spanish</td>
		</tr>
		<tr>
			<td>
				sv</td>
			<td>
				Swedish</td>
		</tr>
		<tr>
			<td>
				tl</td>
			<td>
				Tagalog</td>
		</tr>
		<tr>
			<td>
				ta</td>
			<td>
				Tamil</td>
		</tr>
		<tr>
			<td>
				te</td>
			<td>
				Telugu</td>
		</tr>
		<tr>
			<td>
				th</td>
			<td>
				Thai</td>
		</tr>
		<tr>
			<td>
				tr</td>
			<td>
				Turkish</td>
		</tr>
		<tr>
			<td>
				uk</td>
			<td>
				Ukrainian</td>
		</tr>
		<tr>
			<td>
				vi</td>
			<td>
				Vietnamese</td>
		</tr>
	</tbody>
</table>
