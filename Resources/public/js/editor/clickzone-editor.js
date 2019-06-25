/* 
 * @author Denis N. Ragozin <ragozin at artsofte.ru>
 * @version SVN: $Id$
 * @revision SVN: $Revision$ 
 */
(function($, undefined){


  // получим названием контроллера из пути
  var urlParts = window.location.pathname.split('/');

  var prefix = '';

  if(urlParts[1] !== undefined && urlParts[1].match(/^\w+\.php$/i)) {
    prefix = '/' + urlParts[1];
  }

  var save = function(alias, text, success, error){
    $.ajax({
      url: prefix + '/clickzones/'+ alias,
      type: 'post',
      dataType: 'json',
      data: {
        text: text
      },
      success: function(){
        success.apply(this, arguments);
      },
      error: function(){
        error.apply(this, arguments);
      }
    });
  }

  tinymce.init({
    selector: ".clickzone:not(.clickzone-inline)",
    language_url : '/js/vendor/tinymce/langs/ru.js',
    branding: false,
    plugins: [
      "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
      "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
      "save table contextmenu directionality emoticons template paste textcolor"
    ],
    toolbar1: 'undo redo | styleselect | bold italic strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
    toolbar2: 'link image video',
    image_advtab: true ,
    relative_urls: false,
    inline: true,
    language: 'ru',
    setup : function(ed) {
      var changed = false,
          alias = $(ed.getElement()).attr('id');

      ed.on('change', function(e){
        changed = true;
      }).on('blur', function(e) {
        if (changed){
          changed = false;

          save(alias, e.target.getContent(),
              function(r){},
              function(){
                changed = true;
              }
          );
        }
      }).on('');
    }
  });
  $(function(){
    $('.clickzone-inline').each(function(){
      var editing = false,
          self = $(this);
      self.click(function(e){
        if (!editing){
          editing = true;

          var $input = $('<input type="text"/>').val($(this).hasClass('clickzone-empty') ? '' : $(this).text());
          self.html('').append($input);
          $input.focus().blur(function(){
            var text = $input.val();
            editing = false;
            save(self.attr('id'), text, function(){}, function(){});
            $input.off().remove();

            if (text.length){
              self.removeClass('clickzone-empty');
              self.text(text);
            } else {
              self.addClass('clickzone-empty');
              self.html('<i>нет текста</i>');
            }
          });
        }
      });
    });
  });
})(jQuery);
