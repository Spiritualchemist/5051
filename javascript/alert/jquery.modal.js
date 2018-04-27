/// <reference path="jquery.modal.js"/>
//CJ's l33t dialog box.
$.extend($.fn, {
    hideJmodal: function() {
        $('#jmodal-overlay').animate({ opacity: 0 },'fast', function() { $(this).remove()});
        $('#jquery-jmodal-bg').animate({ opacity: 0 },'fast', function() { $(this).remove()});
        $('#jquery-jmodal').animate({ opacity: 0 },'fast', function() { $(this).remove()});
    },
    hideJmodalInstantly: function() {
      $('#jmodal-overlay').remove();
      $('#jquery-jmodal-bg').remove();
      $('#jquery-jmodal').remove();
    },
    resizeJmodal:function()
    {
      $("#jquery-jmodal-bg").css({height:($(".jmodal-main").height()+20)+"px"});
    },
    jmodal: function(setting) {
        ps = $.extend({},{
            data: {},
            marginTop: 100,
            buttonText: { ok: 'Ok', cancel: 'Cancel' },
            okEvent: function(e) { },
            cancelEvent: function(e) { $.fn.hideJmodalInstantly(); },
            initWidth: 400,
            //fixed: $.browser.msie?false:true,
            fixed: false,
            title: 'Is CJ cool?',
            content: 'The answer your looking for is YES :D',
            jmodalbgCss: {
                'z-index': '238',
                'position': 'absolute',
                'background-color': '#555'
            }
        }, setting);

      ps.docWidth = $(document).width();
      ps.docHeight = $(document).height();
      //if(document.documentElement){
      //  ps.docWidth=document.documentElement.offsetWidth;
      //  ps.docHeight=document.documentElement.offsetHeight;
      //}
      //else if (window.innerWidth && window.innerHeight) {
      //  ps.docWidth=window.innerWidth;
      //  ps.docHeight=window.innerHeight;
      //}

        if ($('#jquery-jmodal').length == 0) {

			if(ps.buttonText.cancel){
					var buttons = '<input type="button" value="' + ps.buttonText.ok + '" />&nbsp;&nbsp;<input type="button" value="' + ps.buttonText.cancel + '" />';
			} else {
					var buttons = '<input type="button" value="' + ps.buttonText.ok + '" />';
			}
            $('<div id="jmodal-overlay" class="jmodal-overlay"/>' +
                '<div id="jquery-jmodal-bg" />' +
                '<div class="jmodal-main" id="jquery-jmodal" >' +
                    '<table cellpadding="0" cellspacing="0">' +
                        //'<tr>' +
                        //    '<td class="jmodal-top-left jmodal-png-fiexed">&nbsp;</td>' +
                        //    '<td class="jmodal-border-top jmodal-png-fiexed">&nbsp;</td>' +
                        //    '<td class="jmodal-top-right jmodal-png-fiexed">&nbsp;</td>' +
                        //'</tr>' +
                    '<tr>' +
                        //'<td class="jmodal-border-left jmodal-png-fiexed">&nbsp;</td>' +
                        '<td >' +
                            '<div class="jmodal-title" />' +
                            '<div class="jmodal-content" id="jmodal-container-content" />' +
                            '<div class="jmodal-bottom">' +
                                buttons +
                            '</div>' +
                        '</td>' +
                        //'<td class="jmodal-border-right jmodal-png-fiexed">&nbsp;</td>' +
                    '</tr>' +
                    //'<tr>' +
                    //    '<td class="jmodal-bottom-left jmodal-png-fiexed">&nbsp;</td>' +
                    //    '<td class="jmodal-border-bottom jmodal-png-fiexed">&nbsp;</td>' +
                    //    '<td class="jmodal-bottom-right jmodal-png-fiexed">&nbsp;</td>' +
                    //'</tr>' +
                    '</table>' +
                '</div>').appendTo($(document.body));
            //$(document.body).find('form:first-child') || $(document.body)
        }
        else {
            $('#jmodal-overlay').css({ opacity: 0, 'display': 'block' });
            $('#jquery-jmodal-bg').css({ opacity: 0, 'display': 'block' });
            $('#jquery-jmodal').css({ opacity: 0, 'display': 'block' });
        }
        
        $('#jmodal-overlay').css({
            height: ps.docHeight,
            opacity: 0.6
        });
        var scrollTOP = document.documentElement.scrollTop;
        jQuery(window).resize(function () { 
      		modal_size();
      	});
        
        function modal_size()
        {
          $('#jquery-jmodal').css({
              position: (ps.fixed ? 'fixed' : 'absolute'),
              width: ps.initWidth,
              left: (ps.docWidth - ps.initWidth) / 2,
              //top: $.browser.msie?(ps.marginTop + scrollTOP):(ps.marginTop),
              top:ps.marginTop + scrollTOP,
              opacity: 1
          }).animate({ opacity: 1 },'fast', function() {
              var me = this;
              $('#jquery-jmodal-bg').css(ps.jmodalbgCss).css({
                position: (ps.fixed ? 'fixed' : 'absolute'),
                  width: ps.initWidth + 20,
                  left: (ps.docWidth - ps.initWidth) / 2 - 10,
                  height: $(me).height() + 20,
                  opacity: 0.5,
                  //top: $.browser.msie?(ps.marginTop - 10 + scrollTOP):(ps.marginTop - 10)
                  top:(ps.marginTop - 10) + scrollTOP
              });
          });
        }
        
        modal_size();
if(ps.buttonText.cancel){
        $('#jquery-jmodal')
            .find('.jmodal-title')
                .html(ps.title)
                    .next()
                        .next()
                            .children('input:first-child')
                                .attr('value', ps.buttonText.ok)
                                    .unbind('click')
                                        .one('click', function(e) {
                                            var args = {
                                                complete: $.fn.hideJmodal
                                            };

                                            ps.okEvent(ps.data, args);
                                        })
                                            .next()
                                                .attr('value', ps.buttonText.cancel)
                                                    .one('click', function(e) {
                                                        var args = {
                                                            complete: $.fn.hideJmodal
                                                        };

                                                        ps.cancelEvent(ps.data, args);
                                                    });
} else {
	$('#jquery-jmodal')
        .find('.jmodal-title')
            .html(ps.title)
                .next()
                    .next()
                        .children('input:first-child')
                            .attr('value', ps.buttonText.ok)
                                .unbind('click')
                                    .one('click', function(e) {
                                        var args = {
                                            complete: $.fn.hideJmodal
                                        };

                                        ps.okEvent(ps.data, args);
                                    })
}
        if (typeof ps.content == 'string') {
            $('#jmodal-container-content').html(ps.content);
        }
        if (typeof ps.content == 'function') {
            var e = $('#jmodal-container-content');
            e.holder = $('#jquery-jmodal');
            e.modalBG = $('#jquery-jmodal-bg');
            ps.content(e);
        }
        
        $("#jmodal-overlay").bgiframe();
    }
});


/*! Copyright (c) 2010 Brandon Aaron (http://brandonaaron.net)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Version 2.1.2
 */

(function($){

$.fn.bgiframe = ($.browser.msie && /msie 6\.0/i.test(navigator.userAgent) ? function(s) {
    s = $.extend({
        top     : 'auto', // auto == .currentStyle.borderTopWidth
        left    : 'auto', // auto == .currentStyle.borderLeftWidth
        width   : 'auto', // auto == offsetWidth
        height  : 'auto', // auto == offsetHeight
        opacity : true,
        src     : 'javascript:false;'
    }, s);
    var html = '<iframe class="bgiframe"frameborder="0"tabindex="-1"src="'+s.src+'"'+
                   'style="display:block;position:absolute;z-index:-1;'+
                       (s.opacity !== false?'filter:Alpha(Opacity=\'0\');':'')+
                       'top:'+(s.top=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderTopWidth)||0)*-1)+\'px\')':prop(s.top))+';'+
                       'left:'+(s.left=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderLeftWidth)||0)*-1)+\'px\')':prop(s.left))+';'+
                       'width:'+(s.width=='auto'?'expression(this.parentNode.offsetWidth+\'px\')':prop(s.width))+';'+
                       'height:'+(s.height=='auto'?'expression(this.parentNode.offsetHeight+\'px\')':prop(s.height))+';'+
                '"/>';
    return this.each(function() {
        if ( $(this).children('iframe.bgiframe').length === 0 )
            this.insertBefore( document.createElement(html), this.firstChild );
    });
} : function() { return this; });

// old alias
$.fn.bgIframe = $.fn.bgiframe;

function prop(n) {
    return n && n.constructor === Number ? n + 'px' : n;
}

})(jQuery);