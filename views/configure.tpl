<section id="block_cms_footer_out" class="footer-block col-xs-12 col-sm-2">
	{if isset($cms_out_footer_arr)}
		<h4>{l s='Block CMS Out' mod='blockcmsfooterout'}</h4>
		{if count($cms_out_footer_arr) > 0}
			<ul class="cat_content">
				{foreach from=$cms_out_footer_arr item=cms_contact_page name=cms_contact_page_name}
					<li class="bullet">
						{if $smarty.foreach.cms_contact_page_name.first}<div class="arr_top_rel"><div></div></div>{/if}
						<a href="{$cms_contact_page.link}" title=""><span>{$cms_contact_page.meta_title|escape:html:'UTF-8'}</span></a>
					</li>
				{/foreach}
				<li><a href="{$link->getPageLink('contact', true)|escape:'html'}" title="{l s='Our contacts' mod='blockcmsfooterout'}">{l s='Our contacts' mod='blockcmsfooterout'}</a></li>
			</ul>
		{/if}
	{else}
		{l s='No cms to show' mod='blockcmsfooterout'}
	{/if}
</section>