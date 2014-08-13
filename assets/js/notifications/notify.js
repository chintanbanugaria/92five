/*
 * Notify 0.0.1 - A Jquery Notification Extension
 * Homepage: redeyeoperation.com/plugins/Notify
 *
 * Author: Jacob Lowe (redeyeoperations.com)
 * Twitter Handle @jacoblowe2dot0
 *
 * Copyright (c) 2010 Jacob Lowe (http://redeyeoperations.com)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * 
 * Built for jQuery library
 * http://jquery.com
 *
 * jQuery.support.transition
  *to verify that CSS3 transition is supported (or any of its browser-specific implementations)
 */

$.support.transition = (function(){ 
    var thisBody = document.body || document.documentElement,
    thisStyle = thisBody.style,
    support = thisStyle.transition !== undefined || thisStyle.WebkitTransition !== undefined || thisStyle.MozTransition !== undefined || thisStyle.MsTransition !== undefined || thisStyle.OTransition !== undefined;
    
    return support; 
}());

//Start of actual extension

(function($){
    
    
    
    var ele, space, timer,
            modTest = $.support.transition,
            //Show animation + classes toggle/reset
            show = (modTest) ?
                    function(element, extClass , txt){
                            element
                                .attr('class', 'notify-' + extClass + ' notify-visible')
                                .html(txt);
                    } :
                    function(element, extClass , txt){      
                            element
                                .attr('class', 'notify-' + extClass + ' notify-visible')
                                .html(txt)
                                .animate({height: '30px'},400);
                    },
            //Hide animation + classes toggle
            hide = (modTest) ?
                    function(element){
                            element
                                    .removeClass('notify-visible')
                                    .addClass('notify-hidden')
                                    .empty();
                    } :
                    function(element){
                            element
                                    .removeClass('notify-visible')
                                    .addClass('notify-hidden')
                                    .empty()
                                    .animate({height: '0px'},400);
                        
                    },
            //Events object
            events = {
                    close : function(){
                        $('.notify-close').bind('click', function(){
                                
                                hide(ele);
                                hide(space);
                                $(this).unbind('click');
                        });
                    },
                    autoClose : function(time){
                        
                             timer = setTimeout(function(){   
                                    hide(ele);
                                    hide(space);
                            },time)
                        
                    }
            },
            //Build - Adding element to the document
            build = function(){
                
                    $('body')
                            .prepend('<div class="notify-hidden" id="notify" rel="Notifications"></div>\
                                                <div id="notify-placeholder"></div>');           
                    ele = $('#notify');
                    space = $('#notify-placeholder');
            
            },
            //Were variables are parsed and order of event are defined
            handle = function(type, txt, options){
                    //Clear timeout if there is one
                    clearTimeout(timer);    
                    //We have option
                    if(typeof (options) === 'object'){            
                            if(options.close){
                                txt = txt + ' <div class="notify-close"></div>';
                                show(ele, type, txt);
                                events.close(ele)
                            }else{                                                
                                    show(ele, type, txt);                          
                            }
                            
                            if(typeof (options.autoClose) === 'number'){
                                        events.autoClose(options.autoClose);
                            }
                            
                            if(options.occupySpace){                               
                                    show(space, 'blank', '');                           
                            }
                    //No options
                    }else{                       
                        show(ele, type, txt);                        
                    }                
            };
    //Extending jquery with a commands
    $.extend({
        notify : {
            success: function(txt, options){
                    handle('success', txt, options);
            },
            error : function(txt, options){
                handle('error', txt, options);
            },
            alert : function(txt, options){
                handle('alert', txt, options);
            },
            basic : function(txt, options){
                handle('basic', txt, options);
            },
            //Only command that really does something differntly
            close : function(){
                hide(ele);
                hide(space);
            }
            //TODO: Add setting function to change defaults
        }
    });
    
    //Script about loaded let build
    build();
    
}(jQuery));