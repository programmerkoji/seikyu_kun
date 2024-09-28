import{g as tt}from"./_commonjsHelpers-725317a4.js";var V={exports:{}};(function(S,P){var y;y=function(){function h(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(i){return Object.getOwnPropertyDescriptor(t,i).enumerable})),n.push.apply(n,r)}return n}function d(t){for(var e=1;e<arguments.length;e++){var n=arguments[e]!=null?arguments[e]:{};e%2?h(Object(n),!0).forEach(function(r){W(t,r,n[r])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):h(Object(n)).forEach(function(r){Object.defineProperty(t,r,Object.getOwnPropertyDescriptor(n,r))})}return t}function b(t){return b=typeof Symbol=="function"&&typeof Symbol.iterator=="symbol"?function(e){return typeof e}:function(e){return e&&typeof Symbol=="function"&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},b(t)}function W(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function D(t){return function(e){if(Array.isArray(e))return T(e)}(t)||function(e){if(typeof Symbol<"u"&&e[Symbol.iterator]!=null||e["@@iterator"]!=null)return Array.from(e)}(t)||H(t)||function(){throw new TypeError(`Invalid attempt to spread non-iterable instance.
In order to be iterable, non-array objects must have a [Symbol.iterator]() method.`)}()}function H(t,e){if(t){if(typeof t=="string")return T(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);return n==="Object"&&t.constructor&&(n=t.constructor.name),n==="Map"||n==="Set"?Array.from(t):n==="Arguments"||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?T(t,e):void 0}}function T(t,e){(e==null||e>t.length)&&(e=t.length);for(var n=0,r=new Array(e);n<e;n++)r[n]=t[n];return r}var M=function(t){return typeof t=="string"?document.querySelector(t):t()},A=function(t,e){var n=typeof t=="string"?document.createElement(t):t;for(var r in e){var i=e[r];if(r==="inside")i.append(n);else if(r==="dest")M(i[0]).insertAdjacentElement(i[1],n);else if(r==="around"){var o=i;o.parentNode.insertBefore(n,o),n.append(o),o.getAttribute("autofocus")!=null&&o.focus()}else r in n?n[r]=i:n.setAttribute(r,i)}return n},_=function(t,e){return t=String(t).toLowerCase(),e?t.normalize("NFD").replace(/[\u0300-\u036f]/g,"").normalize("NFC"):t},q=function(t,e){return A("mark",d({innerHTML:t},typeof e=="string"&&{class:e})).outerHTML},g=function(t,e){e.input.dispatchEvent(new CustomEvent(t,{bubbles:!0,detail:e.feedback,cancelable:!0}))},N=function(t,e,n){var r=n||{},i=r.mode,o=r.diacritics,u=r.highlight,f=_(e,o);if(e=String(e),t=_(t,o),i==="loose"){var l=(t=t.replace(/ /g,"")).length,s=0,c=Array.from(e).map(function(m,p){return s<l&&f[p]===t[s]&&(m=u?q(m,u):m,s++),m}).join("");if(s===l)return c}else{var a=f.indexOf(t);if(~a)return t=e.substring(a,a+t.length),a=u?e.replace(t,q(t,u)):e}},B=function(t,e){return new Promise(function(n,r){var i;return(i=t.data).cache&&i.store?n():new Promise(function(o,u){return typeof i.src=="function"?i.src(e).then(o,u):o(i.src)}).then(function(o){try{return t.feedback=i.store=o,g("response",t),n()}catch(u){return r(u)}},r)})},X=function(t,e){var n=e.data,r=e.searchEngine,i=[];n.store.forEach(function(u,f){var l=function(a){var m=a?u[a]:u,p=typeof r=="function"?r(t,m):N(t,m,{mode:r,diacritics:e.diacritics,highlight:e.resultItem.highlight});if(p){var w={match:p,value:u};a&&(w.key=a),i.push(w)}};if(n.keys){var s,c=function(a,m){var p=typeof Symbol<"u"&&a[Symbol.iterator]||a["@@iterator"];if(!p){if(Array.isArray(a)||(p=H(a))||m&&a&&typeof a.length=="number"){p&&(a=p);var w=0,k=function(){};return{s:k,n:function(){return w>=a.length?{done:!0}:{done:!1,value:a[w++]}},e:function(v){throw v},f:k}}throw new TypeError(`Invalid attempt to iterate non-iterable instance.
In order to be iterable, non-array objects must have a [Symbol.iterator]() method.`)}var L,E=!0,x=!1;return{s:function(){p=p.call(a)},n:function(){var v=p.next();return E=v.done,v},e:function(v){x=!0,L=v},f:function(){try{E||p.return==null||p.return()}finally{if(x)throw L}}}}(n.keys);try{for(c.s();!(s=c.n()).done;)l(s.value)}catch(a){c.e(a)}finally{c.f()}}else l()}),n.filter&&(i=n.filter(i));var o=i.slice(0,e.resultsList.maxResults);e.feedback={query:t,matches:i,results:o},g("results",e)},F="aria-expanded",R="aria-activedescendant",$="aria-selected",z=function(t,e){t.feedback.selection=d({index:e},t.feedback.results[e])},U=function(t){t.isOpen||((t.wrapper||t.input).setAttribute(F,!0),t.list.removeAttribute("hidden"),t.isOpen=!0,g("open",t))},O=function(t){t.isOpen&&((t.wrapper||t.input).setAttribute(F,!1),t.input.setAttribute(R,""),t.list.setAttribute("hidden",""),t.isOpen=!1,g("close",t))},C=function(t,e){var n=e.resultItem,r=e.list.getElementsByTagName(n.tag),i=!!n.selected&&n.selected.split(" ");if(e.isOpen&&r.length){var o,u,f=e.cursor;t>=r.length&&(t=0),t<0&&(t=r.length-1),e.cursor=t,f>-1&&(r[f].removeAttribute($),i&&(u=r[f].classList).remove.apply(u,D(i))),r[t].setAttribute($,!0),i&&(o=r[t].classList).add.apply(o,D(i)),e.input.setAttribute(R,r[e.cursor].id),e.list.scrollTop=r[t].offsetTop-e.list.clientHeight+r[t].clientHeight+5,e.feedback.cursor=e.cursor,z(e,t),g("navigate",e)}},J=function(t){C(t.cursor+1,t)},G=function(t){C(t.cursor-1,t)},j=function(t,e,n){(n=n>=0?n:t.cursor)<0||(t.feedback.event=e,z(t,n),g("selection",t),O(t))};function K(t,e){var n=this;return new Promise(function(r,i){var o,u;return o=e||((u=t.input)instanceof HTMLInputElement||u instanceof HTMLTextAreaElement?u.value:u.innerHTML),function(l,s,c){return s?s(l):l.length>=c}(o=t.query?t.query(o):o,t.trigger,t.threshold)?B(t,o).then(function(l){try{return t.feedback instanceof Error?r():(X(o,t),t.resultsList&&function(s){var c=s.resultsList,a=s.list,m=s.resultItem,p=s.feedback,w=p.matches,k=p.results;if(s.cursor=-1,a.innerHTML="",w.length||c.noResults){var L=new DocumentFragment;k.forEach(function(E,x){var v=A(m.tag,d({id:"".concat(m.id,"_").concat(x),role:"option",innerHTML:E.match,inside:L},m.class&&{class:m.class}));m.element&&m.element(v,E)}),a.append(L),c.element&&c.element(a,p),U(s)}else O(s)}(t),f.call(n))}catch(s){return i(s)}},i):(O(t),f.call(n));function f(){return r()}})}var I=function(t,e){for(var n in t)for(var r in t[n])e(n,r)},Y=function(t){var e,n,r,i=t.events,o=(e=function(){return K(t)},n=t.debounce,function(){clearTimeout(r),r=setTimeout(function(){return e()},n)}),u=t.events=d({input:d({},i&&i.input)},t.resultsList&&{list:i?d({},i.list):{}}),f={input:{input:function(){o()},keydown:function(l){(function(s,c){switch(s.keyCode){case 40:case 38:s.preventDefault(),s.keyCode===40?J(c):G(c);break;case 13:c.submit||s.preventDefault(),c.cursor>=0&&j(c,s);break;case 9:c.resultsList.tabSelect&&c.cursor>=0&&j(c,s);break;case 27:c.input.value="",O(c)}})(l,t)},blur:function(){O(t)}},list:{mousedown:function(l){l.preventDefault()},click:function(l){(function(s,c){var a=c.resultItem.tag.toUpperCase(),m=Array.from(c.list.querySelectorAll(a)),p=s.target.closest(a);p&&p.nodeName===a&&j(c,s,m.indexOf(p))})(l,t)}}};I(f,function(l,s){(t.resultsList||s==="input")&&(u[l][s]||(u[l][s]=f[l][s]))}),I(u,function(l,s){t[l].addEventListener(s,u[l][s])})};function Q(t){var e=this;return new Promise(function(n,r){var i,o,u;if(i=t.placeHolder,u={role:"combobox","aria-owns":(o=t.resultsList).id,"aria-haspopup":!0,"aria-expanded":!1},A(t.input,d(d({"aria-controls":o.id,"aria-autocomplete":"both"},i&&{placeholder:i}),!t.wrapper&&d({},u))),t.wrapper&&(t.wrapper=A("div",d({around:t.input,class:t.name+"_wrapper"},u))),o&&(t.list=A(o.tag,d({dest:[o.destination,o.position],id:o.id,role:"listbox",hidden:"hidden"},o.class&&{class:o.class}))),Y(t),t.data.cache)return B(t).then(function(l){try{return f.call(e)}catch(s){return r(s)}},r);function f(){return g("init",t),n()}return f.call(e)})}function Z(t){var e=t.prototype;e.init=function(){Q(this)},e.start=function(n){K(this,n)},e.unInit=function(){if(this.wrapper){var n=this.wrapper.parentNode;n.insertBefore(this.input,this.wrapper),n.removeChild(this.wrapper)}var r;I((r=this).events,function(i,o){r[i].removeEventListener(o,r.events[i][o])})},e.open=function(){U(this)},e.close=function(){O(this)},e.goTo=function(n){C(n,this)},e.next=function(){J(this)},e.previous=function(){G(this)},e.select=function(n){j(this,null,n)},e.search=function(n,r,i){return N(n,r,i)}}return function t(e){this.options=e,this.id=t.instances=(t.instances||0)+1,this.name="autoComplete",this.wrapper=1,this.threshold=1,this.debounce=0,this.resultsList={position:"afterend",tag:"ul",maxResults:5},this.resultItem={tag:"li"},function(n){var r=n.name,i=n.options,o=n.resultsList,u=n.resultItem;for(var f in i)if(b(i[f])==="object")for(var l in n[f]||(n[f]={}),i[f])n[f][l]=i[f][l];else n[f]=i[f];n.selector=n.selector||"#"+r,o.destination=o.destination||n.selector,o.id=o.id||r+"_list_"+n.id,u.id=u.id||r+"_result",n.input=M(n.selector)}(this),Z.call(this,t),Q(this)}},S.exports=y()})(V);var et=V.exports;const nt=tt(et);document.addEventListener("DOMContentLoaded",()=>{let S=[];const P=new nt({selector:"#company",data:{src:async y=>{try{const d=await(await fetch(`/autocomplete?query=${y}`)).json();return S=d,d.map(b=>b.name)}catch(h){return console.log(h),[]}}},resultsList:{element:(y,h)=>{if(!h.results.length){const d=document.createElement("div");d.setAttribute("class","no_result"),d.innerHTML=`<span>該当する結果が見つかりませんでした: "${h.query}"</span>`,y.prepend(d)}},noResults:!0,id:"company_list"},events:{input:{selection:y=>{const h=y.detail.selection.value;P.input.value=h;const d=S.find(b=>b.name===h);d&&(document.getElementById("company_id").value=d.id)}}},resultItem:{highlight:!0},tabSelect:!0})});
