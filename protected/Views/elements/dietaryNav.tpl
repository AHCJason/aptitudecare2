<li><a href="{$SITE_URL}?module=Dietary">Home</a></li>
<li>Info
	<ul>
		<li><a href="{$SITE_URL}?module={$this->getModule()}&amp;page=info&amp;action=current">Current Menu</a></li>
		<li><a href="{$SITE_URL}?module={$this->getModule()}&amp;page=info&amp;action=facility_menus">Facility Menus</a></li>
		<li><a href="{$SITE_URL}?module={$this->getModule()}&amp;page=info&amp;action=corporate_menus">Corporate Menus</a></li>
		<li><a href="{$SITE_URL}?module={$this->getModule()}&amp;page=info&amp;action=menu_start_date">Menu Start Date</a></li>
		<li><a href="{$SITE_URL}?module={$this->getModule()}&amp;page=info&amp;action=public_page_items">Public Page Items</a></li>
		<li><a href="{$SITE_URL}?module={$this->getModule()}&amp;page=public&amp;location={$location->public_id}" target="_blank">Preview Public Page</a></li>
	</ul>
</li>
<li>Reports
	<ul>
		<li><a href="{$SITE_URL}?module={$this->getModule()}&amp;page=reports&amp;action=menu_changes">Menu Changes</a></li>
	</ul>
</li>
<li>Photos
	<ul>
		<li><a href="{$SITE_URL}?module={$this->getModule()}&amp;page=photos&amp;action=upload_photos&amp;location={$location->public_id}">Upload</a></li>
		<li><a href="{$SITE_URL}?module={$this->getModule()}&amp;page=photos&amp;action=view_photos">View</a></li>
		{if $auth->is_dietary_admin()}
		<li><a href="{$SITE_URL}?module={$this->getModule()}&amp;page=photos&amp;action=manage_photos">Manage</a></li>
		{/if}
	</ul>
</li>