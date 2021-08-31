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

https://github.com/givanz/Vvvebjs
*/

bgcolorClasses = ["bg-primary", "bg-secondary", "bg-success", "bg-danger", "bg-warning", "bg-info", "bg-light", "bg-dark", "bg-white"]

bgcolorSelectOptions = 
[{
	value: "Default",
	text: ""
}, 
{
	value: "bg-primary",
	text: "Primary"
}, {
	value: "bg-secondary",
	text: "Secondary"
}, {
	value: "bg-success",
	text: "Success"
}, {
	value: "bg-danger",
	text: "Danger"
}, {
	value: "bg-warning",
	text: "Warning"
}, {
	value: "bg-info",
	text: "Info"
}, {
	value: "bg-light",
	text: "Light"
}, {
	value: "bg-dark",
	text: "Dark"
}, {
	value: "bg-white",
	text: "White"
}];

function changeNodeName(node, newNodeName)
{
	var newNode;
	newNode = document.createElement(newNodeName);
	attributes = node.get(0).attributes;
	
	for (i = 0, len = attributes.length; i < len; i++) {
		newNode.setAttribute(attributes[i].nodeName, attributes[i].nodeValue);
	}

	$(newNode).append($(node).contents());
	$(node).replaceWith(newNode);
	
	return newNode;
}

Vvveb.ComponentsGroup['Mokyklele Pasaka'] = ["html/free-lessons", "html/courses", "html/courses-free"];

Vvveb.ComponentsGroup['Components'] =
["html/container", "html/gridrow", "html/heading", "html/paragraph", "html/image", "html/jumbotron", "html/carousel","html/listgroup","html/listitem", "html/hr", "html/taglabel", "html/table", "html/link", "html/video"];

var base_sort = 100;//start sorting for base component from 100 to allow extended properties to be first
var style_section = 'style';

Vvveb.Components.add("_base", {
    name: "Element",
	properties: [{
        key: "element_header",
        inputtype: SectionInput,
        name:false,
        sort:base_sort++,
        data: {header:"General"},
    }, {
        name: "Id",
        key: "id",
        htmlAttr: "id",
        sort: base_sort++,
        inline:true,
        col:6,
        inputtype: TextInput
    }, {
        name: "Class",
        key: "class",
        htmlAttr: "class",
        sort: base_sort++,
        inline:true,
        col:6,
        inputtype: TextInput
    }
   ]
});    

//display
Vvveb.Components.extend("_base", "_base", {
	 properties: [
     {
        key: "display_header",
        inputtype: SectionInput,
        name:false,
        sort: base_sort++,
		section: style_section,
        data: {header:"Display"},
    }, {
        name: "Display",
        key: "display",
        htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: SelectInput,
        validValues: ["block", "inline", "inline-block", "none"],
        data: {
            options: [{
                value: "block",
                text: "Block"
            }, {
                value: "inline",
                text: "Inline"
            }, {
                value: "inline-block",
                text: "Inline Block"
            }, {
                value: "none",
                text: "none"
            }]
        }
    }, {
        name: "Position",
        key: "position",
        htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: SelectInput,
        validValues: ["static", "fixed", "relative", "absolute"],
        data: {
            options: [{
                value: "static",
                text: "Static"
            }, {
                value: "fixed",
                text: "Fixed"
            }, {
                value: "relative",
                text: "Relative"
            }, {
                value: "absolute",
                text: "Absolute"
            }]
        }
    }, {
        name: "Top",
        key: "top",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        parent:"",
        inputtype: CssUnitInput
	}, {
        name: "Left",
        key: "left",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        parent:"",
        inputtype: CssUnitInput
    }, {
        name: "Bottom",
        key: "bottom",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        parent:"",
        inputtype: CssUnitInput
	}, {
        name: "Right",
        key: "right",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        parent:"",
        inputtype: CssUnitInput
    },{
        name: "Float",
        key: "float",
        htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:12,
        inline:true,
        inputtype: RadioButtonInput,
        data: {
			extraclass:"btn-group-sm btn-group-fullwidth",
            options: [{
                value: "none",
                icon:"la la-close",
                //text: "None",
                title: "None",
                checked:true,
            }, {
                value: "left",
                //text: "Left",
                title: "Left",
                icon:"la la-align-left",
                checked:false,
            }, {
                value: "right",
                //text: "Right",
                title: "Right",
                icon:"la la-align-right",
                checked:false,
            }],
         }
	}, {
        name: "Opacity",
        key: "opacity",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:12,
		inline:true,
        parent:"",
        inputtype: RangeInput,
        data:{
			max: 1, //max zoom level
			min:0,
			step:0.1
       },
	}, {
        name: "Background Color",
        key: "background-color",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
		htmlAttr: "style",
        inputtype: ColorInput,
	}, {
        name: "Text Color",
        key: "color",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
		htmlAttr: "style",
        inputtype: ColorInput,
  	}]
});    

//Typography
Vvveb.Components.extend("_base", "_base", {
	 properties: [
     {
		key: "typography_header",
		inputtype: SectionInput,
		name:false,
		sort: base_sort++,
		section: style_section,
		data: {header:"Typography"},
 
	}, {
        name: "Font size",
        key: "font-size",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
	}, {
        name: "Font weight",
        key: "font-weight",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: SelectInput,
        data: {
			options: [{
				value: "",
				text: "Default"
			}, {	
				value: "100",
				text: "Thin"
			}, {
				value: "200",
				text: "Extra-Light"
			}, {
				value: "300",
				text: "Light"
			}, {
				value: "400",
				text: "Normal"
			}, {
				value: "500",
				text: "Medium"
			}, {
				value: "600",
				text: "Semi-Bold"
			}, {
				value: "700",
				text: "Bold"
			}, {
				value: "800",
				text: "Extra-Bold"
			}, {
				value: "900",
				text: "Ultra-Bold"
			}],
		}
   }, {
        name: "Font family",
        key: "font-family",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:12,
		inline:true,
        inputtype: SelectInput,
        data: {
			options: [{
				value: "",
				text: "Default"
			}, {
				value: "Arial, Helvetica, sans-serif",
				text: "Arial"
			}, {
                value: "DIN, sans-serif",
                text: "DIN Next"
            }, {
				value: '\'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif',
				text: 'Lucida Grande'
			}, {
				value: '\'Palatino Linotype\', \'Book Antiqua\', Palatino, serif',
				text: 'Palatino Linotype'
			}, {
				value: '\'Times New Roman\', Times, serif',
				text: 'Times New Roman'
			}, {
				value: "Georgia, serif",
				text: "Georgia, serif"
			}, {
				value: "Tahoma, Geneva, sans-serif",
				text: "Tahoma"
			}, {
				value: '\'Comic Sans MS\', cursive, sans-serif',
				text: 'Comic Sans'
			}, {
				value: 'Verdana, Geneva, sans-serif',
				text: 'Verdana'
			}, {
				value: 'Impact, Charcoal, sans-serif',
				text: 'Impact'
			}, {
				value: '\'Arial Black\', Gadget, sans-serif',
				text: 'Arial Black'
			}, {
				value: '\'Trebuchet MS\', Helvetica, sans-serif',
				text: 'Trebuchet'
			}, {
				value: '\'Courier New\', Courier, monospace',
				text: 'Courier New'
			}, {
                value: '\'Brush Script MT\', sans-serif',
                text: 'Brush Script'
            }, {
                value: '\'Playfair Display\', \'Vollkorn\', serif',
                text: 'Playfair Display'
            }]
		}
	}, {
        name: "Font weight",
        key: "font-weight",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: SelectInput,
        data: {
			options: [{
				value: "",
				text: "Default"
			}, {	
				value: "100",
				text: "Thin"
			}, {
				value: "200",
				text: "Extra-Light"
			}, {
				value: "300",
				text: "Light"
			}, {
				value: "400",
				text: "Normal"
			}, {
				value: "500",
				text: "Medium"
			}, {
				value: "600",
				text: "Semi-Bold"
			}, {
				value: "700",
				text: "Bold"
			}, {
				value: "800",
				text: "Extra-Bold"
			}, {
				value: "900",
				text: "Ultra-Bold"
			}],
		}
	}, {
        name: "Text align",
        key: "text-align",
        htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:12,
        inline:true,
        inputtype: RadioButtonInput,
        data: {
			extraclass:"btn-group-sm btn-group-fullwidth",
            options: [{
                value: "none",
                icon:"la la-close",
                //text: "None",
                title: "None",
                checked:true,
            }, {
                value: "left",
                //text: "Left",
                title: "Left",
                icon:"la la-align-left",
                checked:false,
            }, {
                value: "center",
                //text: "Center",
                title: "Center",
                icon:"la la-align-center",
                checked:false,
            }, {
                value: "right",
                //text: "Right",
                title: "Right",
                icon:"la la-align-right",
                checked:false,
            }, {
                value: "justify",
                //text: "justify",
                title: "Justify",
                icon:"la la-align-justify",
                checked:false,
            }],
        },
	}, {
        name: "Line height",
        key: "line-height",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
	}, {
        name: "Letter spacing",
        key: "letter-spacing",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
	}, {
        name: "Text decoration",
        key: "text-decoration-line",
        htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:12,
        inline:true,
        inputtype: RadioButtonInput,
        data: {
			extraclass:"btn-group-sm btn-group-fullwidth",
            options: [{
                value: "none",
                icon:"la la-close",
                //text: "None",
                title: "None",
                checked:true,
            }, {
                value: "underline",
                //text: "Left",
                title: "underline",
                icon:"la la-long-arrow-down",
                checked:false,
            }, {
                value: "overline",
                //text: "Right",
                title: "overline",
                icon:"la la-long-arrow-up",
                checked:false,
            }, {
                value: "line-through",
                //text: "Right",
                title: "Line Through",
                icon:"la la-strikethrough",
                checked:false,
            }, {
                value: "underline overline",
                //text: "justify",
                title: "Underline Overline",
                icon:"la la-arrows-v",
                checked:false,
            }],
        },
	}, {
        name: "Decoration Color",
        key: "text-decoration-color",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
		htmlAttr: "style",
        inputtype: ColorInput,
	}, {
        name: "Decoration style",
        key: "text-decoration-style",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: SelectInput,
        data: {
			options: [{
				value: "",
				text: "Default"
			}, {	
				value: "solid",
				text: "Solid"
			}, {
				value: "wavy",
				text: "Wavy"
			}, {
				value: "dotted",
				text: "Dotted"
			}, {
				value: "dashed",
				text: "Dashed"
			}, {
				value: "double",
				text: "Double"
			}],
		}
  }]
})
    
//Size
Vvveb.Components.extend("_base", "_base", {
	 properties: [{
		key: "size_header",
		inputtype: SectionInput,
		name:false,
		sort: base_sort++,
		section: style_section,
		data: {header:"Size", expanded:false},
	}, {
        name: "Width",
        key: "width",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
	}, {
        name: "Height",
        key: "height",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
	}, {
        name: "Min Width",
        key: "min-width",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
	}, {
        name: "Min Height",
        key: "min-height",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
	}, {
        name: "Max Width",
        key: "max-width",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
	}, {
        name: "Max Height",
        key: "max-height",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
    }]
});

//Margin
Vvveb.Components.extend("_base", "_base", {
	 properties: [{
		key: "margins_header",
		inputtype: SectionInput,
		name:false,
		sort: base_sort++,
		section: style_section,
		data: {header:"Margin", expanded:false},
	}, {
        name: "Top",
        key: "margin-top",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
	}, {
        name: "Right",
        key: "margin-right",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
    }, {
        name: "Bottom",
        key: "margin-bottom",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
    }, {
        name: "Left",
        key: "margin-left",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
    }]
});

//Padding
Vvveb.Components.extend("_base", "_base", {
	 properties: [{
		key: "paddings_header",
		inputtype: SectionInput,
		name:false,
		sort: base_sort++,
		section: style_section,
		data: {header:"Padding", expanded:false},
	}, {
        name: "Top",
        key: "padding-top",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
	}, {
        name: "Right",
        key: "padding-right",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
    }, {
        name: "Bottom",
        key: "padding-bottom",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
    }, {
        name: "Left",
        key: "padding-left",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
    }]
});


//Border
Vvveb.Components.extend("_base", "_base", {
	 properties: [{
		key: "border_header",
		inputtype: SectionInput,
		name:false,
		sort: base_sort++,
		section: style_section,
		data: {header:"Border", expanded:false},
	 }, {        
        name: "Style",
        key: "border-style",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:12,
		inline:true,
        inputtype: SelectInput,
        data: {
			options: [{
				value: "",
				text: "Default"
			}, {	
				value: "solid",
				text: "Solid"
			}, {
				value: "dotted",
				text: "Dotted"
			}, {
				value: "dashed",
				text: "Dashed"
			}],
		}
	}, {
        name: "Width",
        key: "border-width",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
   	}, {
        name: "Color",
        key: "border-color",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
		htmlAttr: "style",
        inputtype: ColorInput,
	}]
});    



//Border radius
Vvveb.Components.extend("_base", "_base", {
	 properties: [{
		key: "border_radius_header",
		inputtype: SectionInput,
		name:false,
		sort: base_sort++,
		section: style_section,
		data: {header:"Border radius", expanded:false},
	}, {
        name: "Top Left",
        key: "border-top-left-radius",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
	}, {
        name: "Top Right",
        key: "border-top-right-radius",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
    }, {
        name: "Bottom Left",
        key: "border-bottom-left-radius",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
    }, {
        name: "Bottom Right",
        key: "border-bottom-right-radius",
		htmlAttr: "style",
        sort: base_sort++,
		section: style_section,
        col:6,
		inline:true,
        inputtype: CssUnitInput
    }]
});

//Background image
Vvveb.Components.extend("_base", "_base", {
	 properties: [{
		key: "background_image_header",
		inputtype: SectionInput,
		name:false,
		sort: base_sort++,
		section: style_section,
		data: {header:"Background Image", expanded:false},
	 },{
        name: "Image",
        key: "Image",
        sort: base_sort++,
		section: style_section,
		//htmlAttr: "style",
        inputtype: ImageInput,
        
        init: function(node) {
			var image = $(node).css("background-image").replace(/^url\(['"]?(.+)['"]?\)/, '$1');
			return image;
        },

		onChange: function(node, value) {
			
			$(node).css('background-image', 'url(' + value + ')');
			
			return node;
		}        

   	}, {
        name: "Repeat",
        key: "background-repeat",
        sort: base_sort++,
		section: style_section,
		htmlAttr: "style",
        inputtype: SelectInput,
        data: {
			options: [{
				value: "",
				text: "Default"
			}, {	
				value: "repeat-x",
				text: "repeat-x"
			}, {
				value: "repeat-y",
				text: "repeat-y"
			}, {
				value: "no-repeat",
				text: "no-repeat"
			}],
		}
   	}, {
        name: "Size",
        key: "background-size",
        sort: base_sort++,
		section: style_section,
		htmlAttr: "style",
        inputtype: SelectInput,
        data: {
			options: [{
				value: "",
				text: "Default"
			}, {	
				value: "contain",
				text: "contain"
			}, {
				value: "cover",
				text: "cover"
			}],
		}
   	}, {
        name: "Position x",
        key: "background-position-x",
        sort: base_sort++,
		section: style_section,
		htmlAttr: "style",
        col:6,
		inline:true,
		inputtype: SelectInput,
        data: {
			options: [{
				value: "",
				text: "Default"
			}, {	
				value: "center",
				text: "center"
			}, {	
				value: "right",
				text: "right"
			}, {
				value: "left",
				text: "left"
			}],
		}
   	}, {
        name: "Position y",
        key: "background-position-y",
        sort: base_sort++,
		section: style_section,
		htmlAttr: "style",
        col:6,
		inline:true,
		inputtype: SelectInput,
        data: {
			options: [{
				value: "",
				text: "Default"
			}, {	
				value: "center",
				text: "center"
			}, {	
				value: "top",
				text: "top"
			}, {
				value: "bottom",
				text: "bottom"
			}],
		}
    }]
});    

Vvveb.Components.extend("_base", "html/container", {
    classes: ["container", "container-fluid"],
    image: "icons/container.svg",
    html: '<div class="container" style="min-height:150px;"><div class="m-5">Container</div></div>',
    name: "Container",
    properties: [
     {
        name: "Type",
        key: "type",
        htmlAttr: "class",
        inputtype: SelectInput,
        validValues: ["container", "container-fluid"],
        data: {
            options: [{
                value: "container",
                text: "Default"
            }, {
                value: "container-fluid",
                text: "Fluid"
            }]
        }
    },
	{
        name: "Background",
        key: "background",
		htmlAttr: "class",
        validValues: bgcolorClasses,
        inputtype: SelectInput,
        data: {
            options: bgcolorSelectOptions
        }
    },
	{
        name: "Background Color",
        key: "background-color",
		htmlAttr: "style",
        inputtype: ColorInput,
    },
	{
        name: "Text Color",
        key: "color",
		htmlAttr: "style",
        inputtype: ColorInput,
    }],
});

Vvveb.Components.extend("_base", "html/heading", {
    image: "icons/heading.svg",
    name: "Heading",
    nodes: ["h1", "h2","h3", "h4","h5","h6"],
    html: "<h1>Heading</h1>",
    
	properties: [
	{
        name: "Size",
        key: "size",
        inputtype: SelectInput,
        
        onChange: function(node, value) {
			
			return changeNodeName(node, "h" + value);
		},	
			
        init: function(node) {
            var regex;
            regex = /H(\d)/.exec(node.nodeName);
            if (regex && regex[1]) {
                return regex[1]
            }
            return 1
        },
        
        data:{
			options: [{
                value: "1",
                text: "1"
            }, {
                value: "2",
                text: "2"
            }, {
                value: "3",
                text: "3"
            }, {
                value: "4",
                text: "4"
            }, {
                value: "5",
                text: "5"
            }, {
                value: "6",
                text: "6"
            }]
       },
    }]
});    
Vvveb.Components.extend("_base", "html/link", {
    nodes: ["a"],
    name: "Link",
    html: '<a href="#" class="d-inline-block"><span>Link</span></a>',
	image: "icons/link.svg",
    properties: [{
        name: "Url",
        key: "href",
        htmlAttr: "href",
        inputtype: LinkInput
    }, {
        name: "Target",
        key: "target",
        htmlAttr: "target",
        inputtype: TextInput
    }]
});
Vvveb.Components.extend("_base", "html/image", {
    nodes: ["img"],
    name: "Image",
    html: '<img src="' +  Vvveb.baseUrl + 'icons/image.svg" height="128" width="128">',
    /*
    afterDrop: function (node)
	{
		node.attr("src", '');
		return node;
	},*/
    image: "icons/image.svg",
    properties: [{
        name: "Image",
        key: "src",
        htmlAttr: "src",
        inputtype: ImageInput
    }, {
        name: "Width",
        key: "width",
        htmlAttr: "width",
        inputtype: TextInput
    }, {
        name: "Height",
        key: "height",
        htmlAttr: "height",
        inputtype: TextInput
    }, {
        name: "Alt",
        key: "alt",
        htmlAttr: "alt",
        inputtype: TextInput
    }]
});

Vvveb.Components.extend("_base", "html/carousel", {
    classes: ["carousel"],
    name: "Carousel",
    html: '<div class="carousel" data-image1="/images/landing/horse.png" data-image2="/images/landing/horse.png" data-image3="/images/landing/horse.png" data-image4="" data-image5="" data-image6="" data-image7="" data-image8="" data-image9=""></div>',
    image: "icons/slide-show.svg",
    properties: [{
        name: "Image",
        key: "data-image1",
        htmlAttr: "data-image1",
        inputtype: ImageInput
    },{
        name: "Image",
        key: "data-image2",
        htmlAttr: "data-image2",
        inputtype: ImageInput
    },{
        name: "Image",
        key: "data-image3",
        htmlAttr: "data-image3",
        inputtype: ImageInput
    },{
        name: "Image",
        key: "data-image4",
        htmlAttr: "data-image4",
        inputtype: ImageInput
    },{
        name: "Image",
        key: "data-image5",
        htmlAttr: "data-image5",
        inputtype: ImageInput
    },{
        name: "Image",
        key: "data-image6",
        htmlAttr: "data-image6",
        inputtype: ImageInput
    },{
        name: "Image",
        key: "data-image7",
        htmlAttr: "data-image7",
        inputtype: ImageInput
    },{
        name: "Image",
        key: "data-image8",
        htmlAttr: "data-image8",
        inputtype: ImageInput
    },{
        name: "Image",
        key: "data-image9",
        htmlAttr: "data-image9",
        inputtype: ImageInput
    }]
});

Vvveb.Components.extend("_base", "html/free-lessons", {
    nodes: ["free-lessons"],
    name: "Free-L form",
    html: '<div id="free-lessons-form"><span>Nemokamos pamokos FORM</span></div>',
    image: "icons/slide-show.svg"
});

Vvveb.Components.extend("_base", "html/courses", {
    nodes: ["courses"],
    name: "Kursai",
    html: '<div id="courses-list"><span>Kursų sąrašas</span></div>',
    image: "icons/slide-show.svg"
});

Vvveb.Components.extend("_base", "html/courses-free", {
    nodes: ["courses-free"],
    name: "Kursai Nemokamai",
    html: '<div id="courses-free"><span>Nemokamų kursų sąrašas</span></div>',
    image: "icons/slide-show.svg"
});

Vvveb.Components.add("html/hr", {
    image: "icons/hr.svg",
    nodes: ["hr"],
    name: "Horizontal Rule",
    html: "<hr>"
});
Vvveb.Components.extend("_base", "html/label", {
    name: "Label",
    nodes: ["label"],
    html: '<label for="">Label</label>',
    properties: [{
        name: "For id",
        htmlAttr: "for",
        key: "for",
        inputtype: TextInput
    }]
});
Vvveb.Components.extend("_base","html/alert", {
    classes: ["alert"],
    name: "Alert",
    image: "icons/alert.svg",
    html: '<div class="alert alert-warning alert-dismissible fade show" role="alert">\
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
			<span aria-hidden="true">&times;</span>\
		  </button>\
		  <strong>Holy guacamole!</strong> You should check in on some of those fields below.\
		</div>',
    properties: [{
        name: "Type",
        key: "type",
        htmlAttr: "class",
        validValues: ["alert-primary", "alert-secondary", "alert-success", "alert-danger", "alert-warning", "alert-info", "alert-light", "alert-dark"],
        inputtype: SelectInput,
        data: {
            options: [{
                value: "alert-primary",
                text: "Default"
            }, {
                value: "alert-secondary",
                text: "Secondary"
            }, {
                value: "alert-success",
                text: "Success"
            }, {
                value: "alert-danger",
                text: "Danger"
            }, {
                value: "alert-warning",
                text: "Warning"
            }, {
                value: "alert-info",
                text: "Info"
            }, {
                value: "alert-light",
                text: "Light"
            }, {
                value: "alert-dark",
                text: "Dark"
            }]
        }
    }]
});
Vvveb.Components.extend("_base", "html/badge", {
    classes: ["badge"],
    image: "icons/badge.svg",
    name: "Badge",
    html: '<span class="badge badge-primary">Primary badge</span>',
    properties: [{
        name: "Color",
        key: "color",
        htmlAttr: "class",
        validValues:["badge-primary", "badge-secondary", "badge-success", "badge-danger", "badge-warning", "badge-info", "badge-light", "badge-dark"],
        inputtype: SelectInput,
        data: {
            options: [{
                value: "",
                text: "Default"
            }, {
                value: "badge-primary",
                text: "Primary"
            }, {
                value: "badge-secondary",
                text: "Secondary"
            }, {
                value: "badge-success",
                text: "Success"
            }, {
                value: "badge-warning",
                text: "Warning"
            }, {
                value: "badge-danger",
                text: "Danger"
            }, {
                value: "badge-info",
                text: "Info"
            }, {
                value: "badge-light",
                text: "Light"
            }, {
                value: "badge-dark",
                text: "Dark"
            }]
        }
     }]
});
Vvveb.Components.extend("_base", "html/card", {
    classes: ["card"],
    image: "icons/panel.svg",
    name: "Card",
    html: '<div class="card">\
		  <img class="card-img-top" src="../libs/builder/icons/image.svg" alt="Card image cap" width="128" height="128">\
		  <div class="card-body">\
			<h4 class="card-title">Card title</h4>\
			<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>\
			<a href="#" class="btn btn-primary">Go somewhere</a>\
		  </div>\
		</div>'
});
Vvveb.Components.extend("_base", "html/listgroup", {
    name: "List Group",
    image: "icons/list_group.svg",
    classes: ["list-group"],
    html: '<ul class="list-group">\n  <li class="list-group-item">\n    <span class="badge">14</span>\n    Cras justo odio\n  </li>\n  <li class="list-group-item">\n    <span class="badge">2</span>\n    Dapibus ac facilisis in\n  </li>\n  <li class="list-group-item">\n    <span class="badge">1</span>\n    Morbi leo risus\n  </li>\n</ul>'
});
Vvveb.Components.extend("_base", "html/listitem", {
    name: "List Item",
    classes: ["list-group-item"],
    html: '<li class="list-group-item"><span class="badge">14</span> Cras justo odio</li>'
});
Vvveb.Components.extend("_base", "html/breadcrumbs", {
    classes: ["breadcrumb"],
    name: "Breadcrumbs",
    image: "icons/breadcrumbs.svg",
    html: '<ol class="breadcrumb">\
		  <li class="breadcrumb-item active"><a href="#">Home</a></li>\
		  <li class="breadcrumb-item active"><a href="#">Library</a></li>\
		  <li class="breadcrumb-item active">Data 3</li>\
		</ol>'
});
Vvveb.Components.extend("_base", "html/breadcrumbitem", {
	classes: ["breadcrumb-item"],
    name: "Breadcrumb Item",
    html: '<li class="breadcrumb-item"><a href="#">Library</a></li>',
    properties: [{
        name: "Active",
        key: "active",
        htmlAttr: "class",
        validValues: ["", "active"],
        inputtype: ToggleInput,
        data: {
            on: "active",
            off: ""
        }
    }]
});
Vvveb.Components.extend("_base", "html/jumbotron", {
    classes: ["jumbotron"],
    image: "icons/jumbotron.svg",
    name: "Jumbotron",
    html: '<div class="jumbotron">\
		  <h1 class="display-3">Hello, world!</h1>\
		  <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>\
		  <hr class="my-4">\
		  <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>\
		  <p class="lead">\
			<a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>\
		  </p>\
		</div>'
});

Vvveb.Components.extend("_base", "html/table", {
    nodes: ["table"],
    classes: ["table"],
    image: "icons/table.svg",
    name: "Table",
    html: '<table class="table">\
		  <thead>\
			<tr>\
			  <th>#</th>\
			  <th>First Name</th>\
			  <th>Last Name</th>\
			  <th>Username</th>\
			</tr>\
		  </thead>\
		  <tbody>\
			<tr>\
			  <th scope="row">1</th>\
			  <td>Mark</td>\
			  <td>Otto</td>\
			  <td>@mdo</td>\
			</tr>\
			<tr>\
			  <th scope="row">2</th>\
			  <td>Jacob</td>\
			  <td>Thornton</td>\
			  <td>@fat</td>\
			</tr>\
			<tr>\
			  <th scope="row">3</th>\
			  <td>Larry</td>\
			  <td>the Bird</td>\
			  <td>@twitter</td>\
			</tr>\
		  </tbody>\
		</table>',
    properties: [
	]
});
Vvveb.Components.extend("_base", "html/tablerow", {
    nodes: ["tr"],
    name: "Table Row",
    html: "<tr><td>Cell 1</td><td>Cell 2</td><td>Cell 3</td></tr>",
    properties: [{
        name: "Type",
        key: "type",
        htmlAttr: "class",
        inputtype: SelectInput,
        validValues: ["", "success", "danger", "warning", "active"],
        data: {
            options: [{
                value: "",
                text: "Default"
            }, {
                value: "success",
                text: "Success"
            }, {
                value: "error",
                text: "Error"
            }, {
                value: "warning",
                text: "Warning"
            }, {
                value: "active",
                text: "Active"
            }]
        }
    }]
});
Vvveb.Components.extend("_base", "html/tablecell", {
    nodes: ["td"],
    name: "Table Cell",
    html: "<td>Cell</td>"
});
Vvveb.Components.extend("_base", "html/tableheadercell", {
    nodes: ["th"],
    name: "Table Header Cell",
    html: "<th>Head</th>"
});
Vvveb.Components.extend("_base", "html/tablehead", {
    nodes: ["thead"],
    name: "Table Head",
    html: "<thead><tr><th>Head 1</th><th>Head 2</th><th>Head 3</th></tr></thead>",
    properties: [{
        name: "Type",
        key: "type",
        htmlAttr: "class",
        inputtype: SelectInput,
        validValues: ["", "success", "danger", "warning", "info"],
        data: {
            options: [{
                value: "",
                text: "Default"
            }, {
                value: "success",
                text: "Success"
            }, {
                value: "anger",
                text: "Error"
            }, {
                value: "warning",
                text: "Warning"
            }, {
                value: "info",
                text: "Info"
            }]
        }
    }]
});
Vvveb.Components.extend("_base", "html/tablebody", {
    nodes: ["tbody"],
    name: "Table Body",
    html: "<tbody><tr><td>Cell 1</td><td>Cell 2</td><td>Cell 3</td></tr></tbody>"
});

// Vvveb.Components.add("html/gridcolumn", {
//     name: "Grid Column",
//     image: "icons/grid_row.svg",
//     classesRegex: ["col-"],
//     html: '<div class="col-sm-4"><h3>col-sm-4</h3></div>',
//     properties: [{
//         name: "Column",
//         key: "column",
//         inputtype: GridInput,
//         data: {hide_remove:true},
		
// 		beforeInit: function(node) {
// 			_class = $(node).attr("class");
			
// 			var reg = /col-([^-\$ ]*)?-?(\d+)/g; 
// 			var match;

// 			while ((match = reg.exec(_class)) != null) {
// 				this.data["col" + ((match[1] != undefined)?"_" + match[1]:"")] = match[2];
// 			}
// 		},
		
// 		onChange: function(node, value, input) {
// 			var _class = node.attr("class");
			
// 			//remove previous breakpoint column size
// 			_class = _class.replace(new RegExp(input.name + '-\\d+?'), '');
// 			//add new column size
// 			if (value) _class +=  ' ' + input.name + '-' + value;
// 			node.attr("class", _class);
			
// 			return node;
// 		},				
// 	}]
// });
Vvveb.Components.add("html/gridrow", {
    name: "Grid Row",
    image: "icons/grid_row.svg",
    classes: ["row"],
    html: '<div class="landing--col--even-1"><h2>Title</h2><p>First column</p></div><div class="landing--col--even-2"><h2>Title</h2><p>Second column</p></div><div class="clear"></div>',
 //    children :[{
	// 	name: "html/gridcolumn",
	// 	classesRegex: ["col-"],
	// }],
	beforeInit: function (node)
	{
		properties = [];
		var i = 0;
		var j = 0;
		
		$(node).find('[class*="col-"]').each(function() {
			_class = $(this).attr("class");
			
			var reg = /col-([^-\$ ]*)?-?(\d+)/g; 
			var match;
			var data = {};

			while ((match = reg.exec(_class)) != null) {
				data["col" + ((match[1] != undefined)?"_" + match[1]:"")] = match[2];
			}
			
			i++;
			properties.push({
				name: "Column " + i,
				key: "column" + i,
				//index: i - 1,
				columnNode: this,
				col:12,
				inline:true,
				inputtype: GridInput,
				data: data,
				onChange: function(node, value, input) {

					//column = $('[class*="col-"]:eq(' + this.index + ')', node);
					var column = $(this.columnNode);
					
					//if remove button is clicked remove column and render row properties
					if (input.nodeName == 'BUTTON')
					{
						column.remove();
						Vvveb.Components.render("html/gridrow");
						return node;
					}

					//if select input then change column class
					_class = column.attr("class");
					
					//remove previous breakpoint column size
					_class = _class.replace(new RegExp(input.name + '-\\d+?'), '');
					//add new column size
					if (value) _class +=  ' ' + input.name + '-' + value;
					column.attr("class", _class);
					
					//console.log(this, node, value, input, input.name);
					
					return node;
				},	
			});
		});
		
		//remove all column properties
		this.properties = this.properties.filter(function(item) {
			return item.key.indexOf("column") === -1;
		});
		
		//add remaining properties to generated column properties
		properties.push(this.properties[0]);
		
		this.properties = properties;
		return node;
	},
    
    properties: [{
        name: "Column",
        key: "column1",
        inputtype: GridInput
	}, {
        name: "Column",
        key: "column1",
        inline:true,
        col:12,
        inputtype: GridInput
	}, {
        name: "",
        key: "addChild",
        inputtype: ButtonInput,
        data: {text:"Add column", icon:"la la-plus"},
        onChange: function(node)
        {
			 $(node).append('<div class="col-3">Col-3</div>');
			 
			 //render component properties again to include the new column inputs
			 Vvveb.Components.render("html/gridrow");
			 
			 return node;
		}
	}]
});


Vvveb.Components.extend("_base", "html/paragraph", {
    nodes: ["p"],
    name: "Paragraph",
	image: "icons/paragraph.svg",
	html: '<p>Lorem ipsum</p>',
    properties: [{
        name: "Text align",
        key: "text-align",
        htmlAttr: "class",
        inputtype: SelectInput,
        validValues: ["", "text-left", "text-center", "text-right"],
        inputtype: RadioButtonInput,
        data: {
			extraclass:"btn-group-sm btn-group-fullwidth",
            options: [{
                value: "",
                icon:"la la-close",
                //text: "None",
                title: "None",
                checked:true,
            }, {
                value: "left",
                //text: "Left",
                title: "text-left",
                icon:"la la-align-left",
                checked:false,
            }, {
                value: "text-center",
                //text: "Center",
                title: "Center",
                icon:"la la-align-center",
                checked:false,
            }, {
                value: "text-right",
                //text: "Right",
                title: "Right",
                icon:"la la-align-right",
                checked:false,
            }],
        },
	}]
});

Vvveb.Components.extend("_base", "html/video", {
    nodes: ["video"],
    name: "Video",
    html: '<video width="320" height="240" playsinline loop autoplay><source src="https://storage.googleapis.com/coverr-main/mp4/Mt_Baker.mp4"><video>',
    dragHtml: '<img  width="320" height="240" src="' + Vvveb.baseUrl + 'icons/video.svg">',
	image: "icons/video.svg",
    properties: [{
        name: "Src",
        child: "source",
        key: "src",
        htmlAttr: "src",
        inputtype: LinkInput
    },{
        name: "Width",
        key: "width",
        htmlAttr: "width",
        inputtype: TextInput
    }, {
        name: "Height",
        key: "height",
        htmlAttr: "height",
        inputtype: TextInput
    },{
        name: "Muted",
        key: "muted",
        htmlAttr: "muted",
        inputtype: CheckboxInput
    },{
        name: "Loop",
        key: "loop",
        htmlAttr: "loop",
        inputtype: CheckboxInput
    },{
        name: "Autoplay",
        key: "autoplay",
        htmlAttr: "autoplay",
        inputtype: CheckboxInput
    },{
        name: "Plays inline",
        key: "playsinline",
        htmlAttr: "playsinline",
        inputtype: CheckboxInput
    },{
        name: "Controls",
        key: "controls",
        htmlAttr: "controls",
        inputtype: CheckboxInput
    }]
});

Vvveb.Components.extend("_base", "_base", {
	 properties: [
	 {
        name: "Font family",
        key: "font-family",
		htmlAttr: "style",
        sort: base_sort++,
        col:6,
		inline:true,
        inputtype: SelectInput,
        data: {
			options: [{
				value: "",
				text: "extended"
			}, {
				value: "Ggoogle ",
				text: "google"
			}]
		}
    }]
});
