(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[17],{495:function(o,c,t){"use strict";t.r(c);var n=t(18),e=t.n(n),r=t(0),s=t(1),a=(t(2),t(7)),u=t.n(a),i=t(42),k=t(6),b=(t(535),function(o){return Object(s.sprintf)(Object(s.__)("%d left in stock","woo-gutenberg-products-block"),o)}),l=function(o,c){return c?Object(s.__)("Available on backorder","woo-gutenberg-products-block"):o?Object(s.__)("In Stock","woo-gutenberg-products-block"):Object(s.__)("Out of Stock","woo-gutenberg-products-block")};c.default=function(o){var c=o.className,t=e()(o,["className"]),n=Object(i.useInnerBlockLayoutContext)().parentClassName,s=Object(i.useProductDataContext)(),a=t.product||s.product||{};if(Object(k.isEmpty)(a)||!a.is_purchasable)return null;var d=!!a.is_in_stock,p=a.low_stock_remaining,w=a.is_on_backorder;return Object(r.createElement)("div",{className:u()(c,"wc-block-components-product-stock-indicator","".concat(n,"__stock-indicator"),{"wc-block-components-product-stock-indicator--in-stock":d,"wc-block-components-product-stock-indicator--out-of-stock":!d,"wc-block-components-product-stock-indicator--low-stock":!!p,"wc-block-components-product-stock-indicator--available-on-backorder":!!w})},p?b(p):l(d,w))}}}]);