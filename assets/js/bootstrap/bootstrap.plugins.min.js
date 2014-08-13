/* ==========================================================
 * bootstrap-placeholder.js v2.0.0
 * http://jasny.github.com/bootstrap/javascript.html#placeholder
 * 
 * Based on work by Daniel Stocks (http://webcloud.se)
 * ==========================================================
 * Copyright 2012 Jasny BV.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */

/* ============================================================
 * bootstrap-rowlink.js v2.0.2
 * http://jasny.github.com/bootstrap/javascript.html#rowlink
 * ============================================================
 * Copyright 2011 Jasny BV, Netherlands.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */

!function(a){var e=function(d,b){this.$element=a(d);this.type=this.$element.data("uploadtype")||(0<this.$element.find(".thumbnail").length?"image":"file");this.$input=this.$element.find(":file");if(0!==this.$input.length){this.name=this.$input.attr("name")||b.name;this.$hidden=this.$element.find(':hidden[name="'+this.name+'"]');0===this.$hidden.length&&(this.$hidden=a('<input type="hidden" />'),this.$element.prepend(this.$hidden));this.$preview=this.$element.find(".fileupload-preview");var c=this.$preview.css("height"); "inline"!=this.$preview.css("display")&&("0px"!=c&&"none"!=c)&&this.$preview.css("line-height",c);this.$remove=this.$element.find('[data-dismiss="fileupload"]');this.listen()}};e.prototype={listen:function(){this.$input.on("change.fileupload",a.proxy(this.change,this));if(this.$remove)this.$remove.on("click.fileupload",a.proxy(this.clear,this))},change:function(a,b){var c=void 0!==a.target.files?a.target.files[0]:{name:a.target.value.replace(/^.+\\/,"")};if(c&&"clear"!==b)if(this.$hidden.val(""), this.$hidden.attr("name",""),this.$input.attr("name",this.name),"image"===this.type&&0<this.$preview.length&&("undefined"!==typeof c.type?c.type.match("image.*"):c.name.match("\\.(gif|png|jpe?g)$"))&&"undefined"!==typeof FileReader){var e=new FileReader,f=this.$preview,g=this.$element;e.onload=function(a){f.html('<img src="'+a.target.result+'" '+("none"!=f.css("max-height")?'style="max-height: '+f.css("max-height")+';"':"")+" />");g.addClass("fileupload-exists").removeClass("fileupload-new")};e.readAsDataURL(c)}else this.$preview.text(c.name), this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(a){this.$hidden.val("");this.$hidden.attr("name",this.name);this.$input.attr("name","");this.$preview.html("");this.$element.addClass("fileupload-new").removeClass("fileupload-exists");this.$input.trigger("change",["clear"]);a.preventDefault();return!1}};a.fn.fileupload=function(d){return this.each(function(){var b=a(this);b.data("fileupload")||b.data("fileupload",new e(this,d))})};a.fn.fileupload.Constructor= e;a(function(){a("body").on("click.fileupload.data-api",'[data-provides="fileupload"]',function(d){var b=a(this);b.data("fileupload")||(b.fileupload(b.data()),"fileupload"==a(d.target).data("dismiss")&&a(d.target).trigger("click.fileupload"))})})}(window.jQuery); !function(a){var e=function(d,b){b=a.extend({},a.fn.rowlink.defaults,b);("tr"==d.nodeName?a(d):a(d).find("tr:has(td)")).each(function(){var c=a(this).find(b.target).first();if(c.length){var d=c.attr("href");a(this).find("td").not(".nolink").click(function(){window.location=d});a(this).addClass("rowlink");c.replaceWith(c.html())}})};a.fn.rowlink=function(d){return this.each(function(){var b=a(this);b.data("rowlink")||b.data("rowlink",new e(this,d))})};a.fn.rowlink.defaults={target:"a"};a.fn.rowlink.Constructor= e;a(function(){a('[data-provides="rowlink"]').each(function(){a(this).rowlink(a(this).data())})})}(window.jQuery);