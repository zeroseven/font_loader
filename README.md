# Font Loader for TYPO3

With this extension external fonts can be loaded directly into your TYPO3 ecosystem and will be delivered from your local webserver. This often optimizes load time and meets requirements from the GDPR (or German DSGVO).

## Installation

Get this extension via `composer req zeroseven/font-loader`.

## Configuration

All you have to do is install the extension. Everything else happens automatically.

## What's happening?

External CSS font files from Google Fonts and Fontawesome are being recognized and loaded if they are being included via TYPO3's own CSS includes. For example like so:

```
page.includeCSS.font = https://fonts.googleapis.com/css?family=Roboto:300,400,500,700
```

The fonts inside the CSS are being analyzed, downloaded onto your local webserver and linked.

### Example:

|            | **HTML** | **CSS** |
|------------|----------|---------|
| **Before** | <pre>&lt;!DOCTYPE html&gt;<br>&lt;html&gt;<br>&lt;head&gt;<br>&nbsp;&nbsp;&lt;title&gt;Website&lt;/title&gt;<br>&nbsp;&nbsp;&lt;link href="<span style='color:#e74c3c'><span>https://</span>fonts.googleapis.com/css?family=roboto</span>" rel="stylesheet" type="text/css"&gt;<br>&lt;/head&gt;</pre> | <pre>@font-face {<br>&nbsp;&nbsp;font-family: 'Roboto';<br>&nbsp;&nbsp;font-style: normal;<br>&nbsp;&nbsp;font-weight: 400;<br>&nbsp;&nbsp;src: url("<span style='color:#e74c3c'><span>https://</span>fonts.gstatic.com/s/v3/x3dkc4PPZa6L4wIg5cZOEsoBly4.ttf</span>") format('truetype');<br>}</pre> |
| **After**  | <pre>&lt;!DOCTYPE html&gt;<br>&lt;html&gt;<br>&lt;head&gt;<br>&nbsp;&nbsp;&lt;title&gt;Website&lt;/title&gt;<br>&nbsp;&nbsp;&lt;link href="<span style='color:#2ecc71'>/typo3temp/zeroseven/local_fonts/e487a6484.css</span>" rel="stylesheet" type="text/css"&gt;<br>&lt;/head&gt;</pre> | <pre>@font-face {<br>&nbsp;&nbsp;font-family: 'Roboto';<br>&nbsp;&nbsp;font-style: normal;<br>&nbsp;&nbsp;font-weight: 400;<br>&nbsp;&nbsp;src: url("<span style='color:#2ecc71'>/typo3temp/zeroseven/local_fonts/329272c5cc2f278d6e1b30c77.ttf</span>") format('truetype');<br>}</pre> |
