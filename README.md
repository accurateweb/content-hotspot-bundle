After install <br />
1. Define hotspot_entity in config
2. Add {% include '@ContentHotspot/Asset/content_hotspot.html.twig' with {'jquery': true, 'tinymce': true} %} in base twig.

For use:
1. Use {{ hotspot_inline('alias', 'default_value') }} or {{ hotspot('alias', 'default_value') }} for render or render and create hotspot.
2. For view and edit hotspots use hotspots=1 in request. User must have role "ROLE_ADMIN".

