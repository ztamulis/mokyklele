/*
Copyright 2017 Ziadin Givan

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

   http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

https://github.com/givanz/VvvebJs
*/

Vvveb.ComponentsGroup['Widgets'] = ["widgets/video", "widgets/facebookpage", "widgets/instagram", "widgets/twitter"/*, "widgets/facebookcomments"*/];

Vvveb.Components.extend("_base", "widgets/video", {
    name: "Video",
    attributes: ["data-component-video"],
    image: "icons/video.svg",
    dragHtml: '<img src="' + Vvveb.baseUrl + 'icons/video.svg" width="100" height="100">', //use image for drag and swap with iframe on drop for drag performance
    html: '<div data-component-video style="min-height:240px;min-width:240px;position:relative"><iframe frameborder="0" src="https://www.youtube.com/embed/-stFvGmg1A8" style="width:100%;height:100%;position:absolute;left:0px;pointer-events:none"></iframe></div>',
    
    
    //url parameters set with onChange
    t:'y',//video type
    video_id:'',//video id
    url: '', //html5 video src
    autoplay: false,
    controls: true,
    loop: false,

	init: function (node)
	{
		iframe = jQuery('iframe', node);
		video = jQuery('video', node);
		
		$("#right-panel [data-key=url]").hide();
		
		//check if html5
		if (video.length) 
		{
			this.url = video.src;
		} else if (iframe.length) //vimeo or youtube
		{
			src = iframe.attr("src");

			if (src && src.indexOf("youtube"))//youtube
			{
				this.video_id = src.match(/youtube.com\/embed\/([^$\?]*)/)[1];
			} else if (src && src.indexOf("vimeo"))//youtube
			{
				this.video_id = src.match(/vimeo.com\/video\/([^$\?]*)/)[1];
			}
		}
		
		$("#right-panel input[name=video_id]").val(this.video_id);
		$("#right-panel input[name=url]").val(this.url);
	},
	
	onChange: function (node, property, value)
	{
		this[property.key] = value;

		//if (property.key == "t")
		{
			switch (this.t)
			{
				case 'y':
				$("#right-panel [data-key=video_id]").show();
				$("#right-panel [data-key=url]").hide();
				newnode = $('<div data-component-video><iframe src="https://www.youtube.com/embed/' + this.video_id + '?&amp;autoplay=' + this.autoplay + '&amp;controls=' + this.controls + '&amp;loop=' + this.loop + '" allowfullscreen="true" style="height: 100%; width: 100%;" frameborder="0"></iframe></div>');
				break;
				case 'v':
				$("#right-panel [data-key=video_id]").show();
				$("#right-panel [data-key=url]").hide();
				newnode = $('<div data-component-video><iframe src="https://player.vimeo.com/video/' + this.video_id + '?&amp;autoplay=' + this.autoplay + '&amp;controls=' + this.controls + '&amp;loop=' + this.loop + '" allowfullscreen="true" style="height: 100%; width: 100%;" frameborder="0"></iframe></div>');
				break;
				case 'h':
				$("#right-panel [data-key=video_id]").hide();
				$("#right-panel [data-key=url]").show();
				newnode = $('<div data-component-video><video src="' + this.url + '" ' + (this.controls?' controls ':'') + (this.loop?' loop ':'') + ' style="height: 100%; width: 100%;"></video></div>');
				break;
			}
			
			node.replaceWith(newnode);
			return newnode;
		}
		return node;
	},	
	
    properties: [{
        name: "Provider",
        key: "t",
        inputtype: SelectInput,
        data:{
			options: [{
                text: "Youtube",
                value: "y"
            }, {
                text: "Vimeo",
                value: "v"
            },{
                text: "HTML5",
                value: "h"
            }]
       },
	 },	       
     {
        name: "Video id",
        key: "video_id",
        inputtype: TextInput,
    },{
        name: "Url",
        key: "url",
        inputtype: TextInput
    },{
        name: "Autoplay",
        key: "autoplay",
        inputtype: CheckboxInput
    },{
        name: "Controls",
        key: "controls",
        inputtype: CheckboxInput
    },{
        name: "Loop",
        key: "loop",
        inputtype: CheckboxInput
    }]
});



Vvveb.Components.extend("_base", "widgets/facebookcomments", {
    name: "Facebook Comments",
    attributes: ["data-component-facebookcomments"],
    image: "icons/facebook.svg",
    dragHtml: '<img src="' + Vvveb.baseUrl + 'icons/facebook.svg">',
    html: '<div  data-component-facebookcomments><script>(function(d, s, id) {\
			  var js, fjs = d.getElementsByTagName(s)[0];\
			  if (d.getElementById(id)) return;\
			  js = d.createElement(s); js.id = id;\
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=";\
			  fjs.parentNode.insertBefore(js, fjs);\
			}(document, \'script\', \'facebook-jssdk\'));</script>\
			<div class="fb-comments" \
			data-href="' + window.location.href + '" \
			data-numposts="5" \
			data-colorscheme="light" \
			data-mobile="" \
			data-order-by="social" \
			data-width="100%" \
			></div></div>',
    properties: [{
        name: "Href",
        key: "business",
        htmlAttr: "data-href",
        child:".fb-comments",
        inputtype: TextInput
    },{		
        name: "Item name",
        key: "item_name",
        htmlAttr: "data-numposts",
        child:".fb-comments",
        inputtype: TextInput
    },{		
        name: "Color scheme",
        key: "colorscheme",
        htmlAttr: "data-colorscheme",
        child:".fb-comments",
        inputtype: TextInput
    },{		
        name: "Order by",
        key: "order-by",
        htmlAttr: "data-order-by",
        child:".fb-comments",
        inputtype: TextInput
    },{		
        name: "Currency code",
        key: "width",
        htmlAttr: "data-width",
        child:".fb-comments",
        inputtype: TextInput
	}]
});

Vvveb.Components.extend("_base", "widgets/instagram", {
    name: "Instagram",
    attributes: ["data-component-instagram"],
    image: "icons/instagram.svg",
    drophtml: '<img src="' + Vvveb.baseUrl + 'icons/instagram.png">',
    html: '<div align=center data-component-instagram>\
			<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/tsxp1hhQTG/" data-instgrm-version="8" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:658px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:8px;"> <div style=" background:#F8F8F8; line-height:0; margin-top:40px; padding:50% 0; text-align:center; width:100%;"> <div style=" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAMUExURczMzPf399fX1+bm5mzY9AMAAADiSURBVDjLvZXbEsMgCES5/P8/t9FuRVCRmU73JWlzosgSIIZURCjo/ad+EQJJB4Hv8BFt+IDpQoCx1wjOSBFhh2XssxEIYn3ulI/6MNReE07UIWJEv8UEOWDS88LY97kqyTliJKKtuYBbruAyVh5wOHiXmpi5we58Ek028czwyuQdLKPG1Bkb4NnM+VeAnfHqn1k4+GPT6uGQcvu2h2OVuIf/gWUFyy8OWEpdyZSa3aVCqpVoVvzZZ2VTnn2wU8qzVjDDetO90GSy9mVLqtgYSy231MxrY6I2gGqjrTY0L8fxCxfCBbhWrsYYAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;"></div></div> <p style=" margin:8px 0 0 0; padding:0 4px;"> <a href="https://www.instagram.com/p/tsxp1hhQTG/" style=" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;" target="_blank">Text</a></p> <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">A post shared by <a href="https://www.instagram.com/instagram/" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;" target="_blank"> Instagram</a> (@instagram) on <time style=" font-family:Arial,sans-serif; font-size:14px; line-height:17px;" datetime="-">-</time></p></div></blockquote>\
			<script async defer src="//www.instagram.com/embed.js"></script>\
		</div>',
    properties: [{
        name: "Widget id",
        key: "instgrm-permalink",
        htmlAttr: "data-instgrm-permalink",
        child: ".instagram-media",
        inputtype: TextInput
    }],
});

Vvveb.Components.extend("_base", "widgets/twitter", {
    name: "Twitter",
    attributes: ["data-component-twitter"],
    image: "icons/twitter.svg",
    dragHtml: '<img src="' + Vvveb.baseUrl + 'icons/twitter.svg">',
    html: '<div data-component-twitter><a class="twitter-timeline" data-dnt="true" data-chrome="nofooter noborders noscrollbar noheader transparent" href="https://twitter.com/twitterapi" href="https://twitter.com/twitterapi" data-widget-id="243046062967885824" ></a>\
			<script>window.twttr = (function(d, s, id) {\
			  var js, fjs = d.getElementsByTagName(s)[0],\
				t = window.twttr || {};\
			  if (d.getElementById(id)) return t;\
			  js = d.createElement(s);\
			  js.id = id;\
			  js.src = "https://platform.twitter.com/widgets.js";\
			  fjs.parentNode.insertBefore(js, fjs);\
			  t._e = [];\
			  t.ready = function(f) {\
				t._e.push(f);\
			  };\
			  return t;\
			}(document, "script", "twitter-wjs"));</script></div>',
    properties: [{
        name: "Widget id",
        key: "widget-id",
        htmlAttr: "data-widget-id",
        child: " > a, > iframe",
        inputtype: TextInput
    }],
});
    
Vvveb.Components.extend("_base", "widgets/facebookpage", {
    name: "Facebook Page Plugin",
    attributes: ["data-component-facebookpage"],
    image: "icons/facebook.svg",
    dropHtml: '<img src="' + Vvveb.baseUrl + 'icons/facebook.png">',
	html: '<div data-component-facebookpage><div class="fb-page" data-href="https://www.facebook.com/facebook" data-appId="100526183620976" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/facebook" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div>\
			<div id="fb-root"></div>\
			<script>(function(d, s, id) {\
			  var appId = document.getElementsByClassName("fb-page")[0].dataset.appid;\
			  var js, fjs = d.getElementsByTagName(s)[0];\
			  js = d.createElement(s); js.id = id;\
			  js.src = \'https://connect.facebook.net/en_EN/sdk.js#xfbml=1&version=v3.0&appId=" + appId + "&autoLogAppEvents=1\';\
			  fjs.parentNode.insertBefore(js, fjs);\
			}(document, \'script\', \'facebook-jssdk\'));</script></div>',

    properties: [{
        name: "Small header",
        key: "small-header",
        htmlAttr: "data-small-header",
        child:".fb-page",
        inputtype: TextInput
    },{		
        name: "Adapt container width",
        key: "adapt-container-width",
        htmlAttr: "data-adapt-container-width",
        child:".fb-page",
        inputtype: TextInput
    },{		
        name: "Hide cover",
        key: "hide-cover",
        htmlAttr: "data-hide-cover",
        child:".fb-page",
        inputtype: TextInput
    },{		
        name: "Show facepile",
        key: "show-facepile",
        htmlAttr: "data-show-facepile",
        child:".fb-page",
        inputtype: TextInput
    },{		
        name: "App Id",
        key: "appid",
        htmlAttr: "data-appId",
        child:".fb-page",
        inputtype: TextInput
	}],
   onChange: function(node, input, value, component) {
	   //console.log(component.html);
	   //console.log(this.html);
	   
	   var newElement = $(this.html);
	   newElement.find(".fb-page").attr(input.htmlAttr, value);
	   
	   console.log(node.parent());
	   console.log(node.parent().html());
	   node.parent().html(newElement.html());

	   console.log(newElement);


	   console.log(newElement.html());

	   return newElement;
	}	
});

