'Notice' is a small piece of code you can place in your site's HTML which stops Microsoft Internet Explorer (MSIE / Explorer) from rendering your page. Along-side this, a notification alerts the user he is using MSIE and prompts him / her to download Firefox instead.

We've all been there. We design our site with Internet Explorer in mind, only to find we have to resort to numerous hacks and complicated code to get our site looking like it should in MSIE. Numerous Web Citizens have written hacks and workarounds for MSIE, only to be dismayed at all the extra effort they had to put in to get their designs cross-compatible with MSIE.

'Notice' is very easy to setup. All you need is four lines of code, plus a notice page which you can download...
Try placing it into the HEAD HTML tag of the document.

<!--[if IE]>
<script>location.href='http://iwantaneff.in/notice/'</script>
<noscript>
<meta http-equiv="refresh" content="0;url=http://iwantaneff.in/notice/">
</noscript>
<![endif]-->