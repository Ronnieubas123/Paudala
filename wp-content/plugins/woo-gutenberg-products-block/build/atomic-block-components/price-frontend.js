(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[6],{119:function(e,r){},142:function(e,r,t){"use strict";t.d(r,"c",(function(){return f})),t.d(r,"b",(function(){return y})),t.d(r,"a",(function(){return b}));var n=t(6),c=t.n(n),a=t(23),o=t.n(a),u=t(2);function i(e,r){var t=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);r&&(n=n.filter((function(r){return Object.getOwnPropertyDescriptor(e,r).enumerable}))),t.push.apply(t,n)}return t}function p(e){for(var r=1;r<arguments.length;r++){var t=null!=arguments[r]?arguments[r]:{};r%2?i(Object(t),!0).forEach((function(r){c()(e,r,t[r])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(t)):i(Object(t)).forEach((function(r){Object.defineProperty(e,r,Object.getOwnPropertyDescriptor(t,r))}))}return e}var s,l,m={code:u.CURRENCY.code,symbol:u.CURRENCY.symbol,thousandSeparator:u.CURRENCY.thousandSeparator,decimalSeparator:u.CURRENCY.decimalSeparator,minorUnit:u.CURRENCY.precision,prefix:(s=u.CURRENCY.symbol,l=u.CURRENCY.symbolPosition,{left:s,left_space:" "+s,right:"",right_space:""}[l]||""),suffix:function(e,r){return{left:"",left_space:"",right:e,right_space:" "+e}[r]||""}(u.CURRENCY.symbol,u.CURRENCY.symbolPosition)},f=function(e){if(!e||"object"!==o()(e))return m;var r=e.currency_code,t=e.currency_symbol,n=e.currency_thousand_separator,c=e.currency_decimal_separator,a=e.currency_minor_unit,u=e.currency_prefix,i=e.currency_suffix;return{code:r||"USD",symbol:t||"$",thousandSeparator:"string"==typeof n?n:",",decimalSeparator:"string"==typeof c?c:".",minorUnit:Number.isFinite(a)?a:2,prefix:"string"==typeof u?u:"$",suffix:"string"==typeof i?i:""}},y=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};return p(p({},m),e)},b=function(e,r){if(""===e||void 0===e)return"";var t=parseInt(e,10);if(!Number.isFinite(t))return"";var n=y(r),c=t/Math.pow(10,n.minorUnit),a=n.prefix+c+n.suffix,o=document.createElement("textarea");return o.innerHTML=a,o.value}},268:function(e,r){},281:function(e,r,t){"use strict";t.r(r);var n=t(15),c=t.n(n),a=(t(4),t(5)),o=t.n(a),u=t(39),i=t(142),p=t(67),s=(t(268),function(e){return e.price_range&&e.price_range.min_amount&&e.price_range.max_amount}),l=function(e){var r=e.currency,t=e.minAmount,n=e.maxAmount,c=Object(p.useInnerBlockLayoutContext)().parentClassName;return React.createElement("span",{className:o()("wc-block-components-product-price__value","".concat(c,"__product-price__value"))},React.createElement(u.a,{currency:r,value:t})," — ",React.createElement(u.a,{currency:r,value:n}))},m=function(e){var r=e.currency,t=e.price,n=e.regularPrice,c=Object(p.useInnerBlockLayoutContext)().parentClassName;return React.createElement(React.Fragment,null,n!==t&&React.createElement("del",{className:o()("wc-block-components-product-price__regular","".concat(c,"__product-price__regular"))},React.createElement(u.a,{currency:r,value:n})),React.createElement("span",{className:o()("wc-block-components-product-price__value","".concat(c,"__product-price__value"))},React.createElement(u.a,{currency:r,value:t})))};r.default=function(e){var r=e.className,t=c()(e,["className"]),n=Object(p.useInnerBlockLayoutContext)().parentClassName,a=Object(p.useProductDataContext)(),u=t.product||a.product;if(!u)return React.createElement("div",{className:o()(r,"price","wc-block-components-product-price","".concat(n,"__product-price"))});var f=u.prices||{},y=Object(i.c)(f);return React.createElement("div",{className:o()(r,"price","wc-block-components-product-price","".concat(n,"__product-price"))},s(f)?React.createElement(l,{currency:y,minAmount:f.price_range.min_amount,maxAmount:f.price_range.max_amount}):React.createElement(m,{currency:y,price:f.price,regularPrice:f.regular_price}))}},39:function(e,r,t){"use strict";var n=t(11),c=t.n(n),a=t(6),o=t.n(a),u=t(15),i=t.n(u),p=t(96),s=t(5),l=t.n(s);t(119);function m(e,r){var t=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);r&&(n=n.filter((function(r){return Object.getOwnPropertyDescriptor(e,r).enumerable}))),t.push.apply(t,n)}return t}function f(e){for(var r=1;r<arguments.length;r++){var t=null!=arguments[r]?arguments[r]:{};r%2?m(Object(t),!0).forEach((function(r){o()(e,r,t[r])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(t)):m(Object(t)).forEach((function(r){Object.defineProperty(e,r,Object.getOwnPropertyDescriptor(t,r))}))}return e}r.a=function(e){var r=e.className,t=e.value,n=e.currency,a=e.onValueChange,o=i()(e,["className","value","currency","onValueChange"]);if("-"===t)return null;var u=t/Math.pow(10,n.minorUnit);if(!Number.isFinite(u))return null;var s=l()("wc-block-formatted-money-amount","wc-block-components-formatted-money-amount",r),m=f(f(f({displayType:"text"},o),function(e){return{thousandSeparator:e.thousandSeparator,decimalSeparator:e.decimalSeparator,decimalScale:e.minorUnit,fixedDecimalScale:!0,prefix:e.prefix,suffix:e.suffix,isNumericString:!0}}(n)),{},{value:void 0,currency:void 0,onValueChange:void 0}),y=a?function(e){var r=e.value*Math.pow(10,n.minorUnit);a(r)}:function(){};return React.createElement(p.a,c()({className:s},m,{value:u,onValueChange:y}))}}}]);