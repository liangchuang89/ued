/**
 * ���ݶ���������¼�������
 * @param {Object} el �����¼���Ԫ��.
 * @param {String} event �¼���.
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
 * �����˵��������ڲ�֧��:hoverα����������IE6��
 * @param {String} menu �˵�������id.
 */
function initHoverMenu(menu) {
    var D = YAHOO.util.Dom;
    if (!(menu = D.get(menu)))
        return;

    // ��������¼�
    menu.onmouseenter = function() {
        D.addClass(this, 'hover');
    };
    menu.onmouseleave = function() {
        D.removeClass(this, 'hover');
    };
}

//����ĺ�����Ϊ�������н��ҳ����ʵ�ִ��ڹ���
//@pos {String} id,x,y  idΪiframe��id��Ϊ�˼���iframe�ڸ�ҳ���λ�ã�xΪ�������λ�ã�һ��Ϊ0���� yΪ�������
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
    * ����״̬
    */
    available: function() {
      S.each(this, function(n) {
        S.one(n).available();
      });
    },

    /**
    * ������״̬
    */
    disable: function() {
      S.each(this, function(n) {
        S.one(n).disable();
      });
    }
  });

  S.augment(S.Node, {

    /**
    * ����״̬
    */
    available: function() {
      this[0].disabled = false;
      this.removeClass('disabled');
    },

    /**
    * ������״̬
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