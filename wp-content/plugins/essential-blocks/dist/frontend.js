(()=>{"use strict";var e={d:(n,o)=>{for(var t in o)e.o(o,t)&&!e.o(n,t)&&Object.defineProperty(n,t,{enumerable:!0,get:o[t]})},o:(e,n)=>Object.prototype.hasOwnProperty.call(e,n),r:e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})}},n={};e.r(n),e.d(n,{EBGetIconClass:()=>r,EBGetIconType:()=>o,EBRenderIcon:()=>t});var o=function(e){return e.includes("fa-")?"fontawesome":"dashicon"},t=function(e,n,o){return"dashicon"===e?'<span class="dashicon dashicons '+o+" "+n+'"></span>':"fontawesome"===e?'<i class="'+o+" "+n+'"></i>':"Invalid icon type"},r=function(e){return e?e.includes("fa-")?e:"dashicon dashicons "+e:""};window.eb_frontend=n})();