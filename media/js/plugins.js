/**
 * Инициализация плагинов для работы конкретного проекта
 */
// // usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function f() {
    log.history = log.history || [];
    log.history.push(arguments);
    if (this.console) {
        var args = arguments, newarr;
        args.callee = args.callee.caller;
        newarr = [].slice.call(args);
        if (typeof console.log === 'object')
            log.apply.call(console.log, console, newarr);
        else
            console.log.apply(console, newarr);
    }
};

// make it safe to use console.log always
(function(a) {
    function b() {
    }
    for (var c = "assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","), d; !!(d = c.pop()); ) {
        a[d] = a[d] || b;
    }
})
        (function() {
            try {
                console.log();
                return window.console;
            } catch (a) {
                return (window.console = {});
            }
        }());


// place any jQuery/helper plugins in here, instead of separate, slower script files.

/*
 * Инициализация плагинов
 */
$(document).ready(function() { 
	   
    /**
     * pop-up окно  Не удаляй пока, мало ли понадобиться
     */
    /*$("a.iframe").fancybox({
        "frameWidth": 220, // ширина окна, px (425px - по умолчанию)
        "frameHeight": 200, // высота окна, px(355px - по умолчанию)	
		'overlayOpacity': 0.9						  
    });  
    */
	
	/*
	*  Карусель в проектах
	*/
	/*
    $('#foo').carouFredSel({
        prev: '#prev',
        next: '#next',
        pagination: false,
        auto: false
    });*/
    
	/*
     * Лайтбокс картинок
     */ 
	 /*
    $("a.popup").fancybox({
        'titlePosition': 'over',
        'overlayOpacity': 0.9,		
    });		
	*/
});
