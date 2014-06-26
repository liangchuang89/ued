/**
 * 兼容多浏览器的事件触发器
 * @param {Object} el 触发事件的元素.
 * @param {String} event 事件名.
 */
var fireEvent = function(el, event) {
    if(document.createEvent){
        var e = document.createEvent('HTMLEvents');
        e.initEvent(event, false, true);
        el.dispatchEvent(e);
    }else{
        try{
            el.fireEvent('on' + event);
        }catch(e){}
    }
    try {el[event]();}catch (e) {}
};
/**
 * 悬浮菜单，仅用于不支持:hover伪类的浏览器（IE6）
 * @param {String} menu 菜单触发器id.
 */
function initHoverMenu(menu) {
    var D = YAHOO.util.Dom;
    if (!(menu = D.get(menu)))
        return;

    // 添加悬浮事件
    menu.onmouseenter = function() {
        D.addClass(this, 'hover');
    };
    menu.onmouseleave = function() {
        D.removeClass(this, 'hover');
    };
}

//新添的函数，为北京旅行结果页调用实现窗口滚动
//@pos {String} id,x,y  id为iframe的id，为了计算iframe在父页面的位置，x为横向滚动位置（一般为0）， y为纵向滚动
function setScroll(pos) {
    var posArr = pos.split(",");
    
    if(posArr.length == 3 ){
         var searchArea = document.getElementById(posArr[0]);
      searchArea && window.scroll(posArr[1], parseInt(posArr[2]) + searchArea.offsetTop);
    }
};

KISSY.add('node-enhance', function(S) {
  S.augment(S.NodeList, {

    /**
    * 可用状态
    */
    available: function() {
      S.each(this, function(n) {
        S.one(n).available();
      });
    },

    /**
    * 不可用状态
    */
    disable: function() {
      S.each(this, function(n) {
        S.one(n).disable();
      });
    }
  });

  S.augment(S.Node, {

    /**
    * 可用状态
    */
    available: function() {
      this[0].disabled = false;
      this.removeClass('disabled');
    },

    /**
    * 不可用状态
    */
    disable: function() {
      this[0].disabled = true;
      this.addClass('disabled');
    },

    //cross browser selection
    //support IE/FF/Chrome/Safari
    select: function(start, end) {
      var self = this;
      //IE
      if (document.selection) {
        S.each(self, function(s) {
          var r = s.createTextRange();
          r.collapse(true);
          r.moveStart('character', start);
          r.moveEnd('character', end);
          r.select();
          
        });
        //FF/Chrome/Safari
      } else {
        S.each(self, function(s) {
          s.focus();
          s.selectionStart = start;
          s.selectionEnd = end;
        });
      }
    }
  });
});

KISSY.add('IE6Hover', function(S, undefined) {
    var S = KISSY, D = S.DOM, E = S.Event;
    var IE6Hover = function(el, cls) {
        var IE6 = !!(S.UA.ie < 7);
        if (!IE6 || !el) return;
        var _cls = cls || 'hover';

        E.on(el, 'mouseenter', function() {
            D.addClass(this, _cls);
        });

        E.on(el, 'mouseleave', function() {
            D.removeClass(this, _cls);
           
        });
    };
    S.IE6Hover = IE6Hover;
});