M.add("www-hub",function(t){"use strict";function e(e){return e instanceof Error&&M._ERRORS.push(e),new t.Promise(function(t){t(null)})}function n(n){return"function"==typeof n&&(n=new t.Promise(n)),t.when(n,e,e)}function i(){d&&window.console&&console.log&&console.log.apply&&console.log.apply(console,arguments)}function s(t){if(!t)return"";for(var e=t.split("-"),n="",i=null;i=e.shift();)n+=i.charAt(0).toUpperCase()+i.substr(1);return n}function o(e){if(!e)return m;var n=t.mt[p]||t.mt;try{for(var i,s=e.split("."),o=n;i=s.shift();)o=o[i];return o&&o!==n?o:m}catch(a){return m}}function a(t,e){return function(){var n=o(e)||m;return(n[t]||m[t]).apply(n,arguments)}}function r(e){var n={};return t.Object.each(m,function(t,i){n[i]=a(i,e)}),n}function u(e){if(!e)return null;this.element=e,this.stamp=t.stamp(e),this.setData("stamp",this.stamp),this.getState()||this.setState(0),this.url=this.getData("url");var n=this.getData("config");try{this.config=t.JSON.parse(n)}catch(i){this.config=n}"load"===this.getData("laziness")&&this.setState(1),n=null,this.publishEvent(),this.publishNodeEvent()}function c(){this.uses=[p+"-base"],this.css=[],this.cssIndex=0,this.promise=t.when(),this.podList={},this.updateInfo={},this.updateValue={},this.publishEvent()}t.namespace("mt.www.Hub");var h="J-hub",p=M.APP||"www",d=~(""+location.search).indexOf("jslog=verbose");t.Promise&&"function"!=typeof t.Promise.all&&(t.Promise.all=t.batch),M._ERRORS=M._ERRORS||[];var f={scan:10,render:20,init:30,beforeupdate:40,update:50,teardown:0},l=0;t.Object.each(f,function(t){t>l&&(l=t)});var m={render:function(){},init:function(){},beforeupdate:function(e,n){if(!e)return null;var i=n||{};return t.Lang.isObject(i)||(i={args:n}),t.merge(i,{act:e})},update:function(e,n){if(n&&e)try{n=t.JSON.parse(n),t.Lang.isString(n)?e.setHTML(n):t.Lang.isObject(n)&&404!==n.status&&n.html&&e.setHTML(n.html)}catch(i){e.setHTML(n)}},teardown:function(t){t&&t.purge(!0)}},y=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||function(t){window.setTimeout(t,1e3/60)};u.prototype.publishEvent=function(){t.Array.each(["scan","render","init","beforeupdate","update","teardown"],function(t){this.publish(t,{defaultFn:function(e){i(this.constructor.name,e.type),this.setState(e.type),this[t](e)}}),this.on(t,this.checkState)},this),this.publish("ready",{fireOnce:!0,async:!0});var e={bubbles:!0};this.publish("resume",e),this.publish("didReceiveScan",e),this.publish("didReceiveBeforeupdate",e),this.publish("didReceiveUpdate",e)},u.prototype.publishNodeEvent=function(){t.Array.each(["pause","resume"],function(t){this.on(t,this[t]),this.element.on("hub:"+t,function(){this.fire(t)},this)},this)},u.prototype.scan=function(){var t,e=this.getData("module"),n=p+"-";e&&(t=0===e.indexOf(n)?e.substr(n.length):e),t=this.getData("namespace")||s(t),this.execute=r(t);var i=this.getData("css");(i||e)&&this.fire("didReceiveScan",{css:i,module:e})},u.prototype.render=function(t){var e=t.type;this.execute[e](this.element)},u.prototype.init=function(t){var e=t.type;this.execute[e](this.element,this.config)},u.prototype.beforeupdate=function(e){var n=e.type,i=this.execute[n](this.url,this.config);i&&this.fire("didReceiveBeforeupdate",{updateInfo:t.JSON.stringify(i),stamp:this.stamp})},u.prototype.update=function(e){var n=e.type;y(t.bind(this.execute[n],this,this.element,e.value,this.config)),this.fire("didReceiveUpdate",{stamp:this.stamp})},u.prototype.teardown=function(t){var e=t.type;this.execute[e](this.element)},u.prototype.checkState=function(t){var e=t.type,n=this.getState();1&n&&t.preventDefault(),n>=f[e]&&t.preventDefault()},u.prototype.pause=function(){i("pause from",this.stamp);var t=this.getState();this.setState(1|t)},u.prototype.resume=function(){i("resume from",this.stamp);var t=this.getState();this.setState(1^(1|t))},u.prototype.getData=function(t){return this.element.getAttribute("data-hub"+t)},u.prototype.setData=function(t,e){return t?"undefined"==typeof e?this.element.removeAttribute("data-hub"+t):void this.element.setAttribute("data-hub"+t,e):void 0},u.prototype.getState=function(){return 1*this.getData("state")||0},u.prototype.setState=function(t){f.hasOwnProperty(t)&&(t=f[t]),this.setData("state",t)},u.prototype.isReady=function(){return this.getState()===l},c.prototype.publishEvent=function(){t.Array.each(["didReceiveScan","didReceiveBeforeupdate","didReceiveUpdate"],function(t){this.publish(t,{defaultFn:this[t]})},this),t.Array.each(["resume","ready"],function(t){this.publish(t,{async:!0,defaultFn:this[t]})},this)},c.prototype.scan=function(){i(this.constructor.name,"scan"),this.styleSheets=t.all("link[rel='stylesheets']"),t.Object.each(this.podList,function(t){t.fire("scan")}),this.styleSheets=null;var e=this;return new t.Promise(function(n){t.Promise.all(e.when(e.getCSS()),e.when(e.getJS())).then(function(){n()})})},c.prototype.didReceiveScan=function(t){i(this.constructor.name,t.type,"css",t.css,"module",t.module),t.css&&this.addCSS(t.css),t.module&&this.uses.push(t.module)},t.Array.each(["render","init","beforeupdate"],function(e){c.prototype[e]=function(){i(this.constructor.name,e),this.updateInfo={},t.Object.each(this.podList,function(t){t.fire(e)})}},this),c.prototype.didReceiveBeforeupdate=function(t){i(this.constructor.name,t.type),t.updateInfo&&t.stamp&&(this.updateInfo[t.stamp]=t.updateInfo)},c.prototype.update=function(){i(this.constructor.name,"update"),this.updateValue=this.updateValue||{};var e=this;return new t.Promise(function(i){n(e.requestUpdate(e.updateInfo)).then(t.bind(e.dispatchUpdate,e)).then(function(){i(null)})})},c.prototype.requestUpdate=function(e){i(this.constructor.name,"requestUpdate",e);var n=this;return new t.Promise(function(i,s){if(t.Object.isEmpty(e))return i(null);n.updateValue=n.updateValue||{};var o="/multiact/default/"+(location.pathname||"");t.io(o,{method:"post",data:e,on:{success:function(e,s){n.updateInfo={};var o=t.JSON.parse(s.responseText);t.mix(n.updateValue,o,!0),i(null)},failure:function(t,e){s(new Error("multiact fails with status "+(e.status||"null")))}}})})},c.prototype.dispatchUpdate=function(){i(this.constructor.name,"dispatchUpdate"),t.Object.each(this.podList,function(t,e){this.updateValue.hasOwnProperty(e)&&(i("Dispatching update to",e),t.fire("update",{value:this.updateValue[e]}))},this)},c.prototype.didReceiveUpdate=function(t){i(this.constructor.name,t.type,t.stamp),t.stamp&&delete this.updateValue[t.stamp]},c.prototype.resume=function(){this.runAfterCurrentDigestCycle(this.fireSequence)},c.prototype.fireSequence=function(){this.readiness=!1,this.then(this.scan,this.render,this.init,this.beforeupdate,this.update),this.then(t.bind(this.fire,this,"ready"))},c.prototype.start=function(e){e=e||"."+h,this.then(function(){i(this.constructor.name,"start"),t.all(e).each(this.addElement,this)}),this.fireSequence()},c.prototype.ready=function(){i(this.constructor.name,"ready"),t.Object.each(this.podList,function(t){t.isReady()&&t.fire("ready")}),this.readiness=!0},c.prototype.then=function(){if(arguments.length)for(var e=0;e<arguments.length;e++)this.promise=this.promise.then(t.bind(arguments[e],this));return this},c.prototype.when=function(e){return"function"==typeof e&&(e=t.bind(e,this)),n(e)},c.prototype.runAfterCurrentDigestCycle=function(t){this.readiness?t.call(this):this.onceAfter("ready",function(){i("Running after current digest cycle"),t.call(this)})},c.prototype.addElement=function(t){if(t.hasClass(h)&&!this.getPodByElement(t)){var e=new u(t);e&&(e.addTarget(this),this.podList[e.stamp]=e)}},c.prototype.getPodByElement=function(e){if(!e)return null;e.hasOwnProperty("_node")||(e=t.one(e));var n=e.getAttribute("data-hubstamp");if(!n)return null;var i=this.podList[n];return i&&i instanceof u?i:null},c.prototype.addCSS=function(e){var n;t.Array.each(e.split(";"),function(e){e&&(~t.Array.indexOf(this.css,e)||(n=!1,this.styleSheets instanceof t.NodeList&&this.styleSheets.some(function(t){return~t.get("href").indexOf(e)?(n=!0,!0):void 0}),n||this.css.push(e)))},this)},c.prototype.getCSS=function(){var e=this.css.slice(this.cssIndex);return new t.Promise(function(n,s){return e.length?(e=(M.COMBO_BASE||"")+e.join(";"),void t.Get.css(e,function(t){return t?void s(t):(b.cssIndex=b.css.length,i("Fetched CSS From",e),void n(null))})):n(null)})},c.prototype.getJS=function(){var e=this.uses=t.Array.dedupe(this.uses);return new t.Promise(function(n){t.use(e,function(){i("Fetched JS",e),n(null)})})},c.prototype.checkLaziness=function(e){this.runAfterCurrentDigestCycle(function(){t.Object.each(this.podList,function(t){t.getData("laziness")===e&&t.element.fire("hub:resume")},this)})};var v={emitFacade:!0,async:!1,bubbles:!1};t.augment(u,t.EventTarget,!1,null,v),t.augment(c,t.EventTarget,!1,null,v);var b=new c;t.Event.define("hub:ready",{on:function(t,e,n){var i=b.getPodByElement(t);i&&(e._handle=i.on("ready",function(t){n.fire(t)}))},detach:function(t,e){e._handle.detach()}}),t.mt.www.Hub.init=function(t){b.start(t)},M._autoinit=M._autoinit||[],M._autoinit.push(function(e){e&&e.className&&!~e.className.indexOf(h)&&(i("start Hub autoinit",e),t.mt.www.Hub.init(e))}),t.on("load",function(){b.checkLaziness("load")})},"1.0.0",{requires:["node","event","event-custom","io-base","promise"]});