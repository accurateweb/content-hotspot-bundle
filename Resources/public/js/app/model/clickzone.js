/* 
 * @author Denis N. Ragozin <ragozin at artsofte.ru>
 * @version SVN: $Id$
 * @revision SVN: $Revision$ 
 */
define(function(require){
  var Backbone = require('backbone'),
      app = require('core-app');
  
  return Backbone.Model.extend({
    urlRoot: app.url('/clickzones'),
    idAttribute: 'alias',
    defaults: {
      text: '',
      inline: false
    }
  });
});

