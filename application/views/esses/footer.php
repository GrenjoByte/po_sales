	<!-- <div class="ui padded grid centered psa-grey middle">
	<div class="sixteen wide mobile twelve wide tablet eleven wide computer ten wide large screen column">
		<div class="ui basic segment left floated">
			<div class="ui items">
				<div class="item">
					<div class="ui small image">
						<img src="<?php echo base_url();?>photos/icons/psa.png" id="page_logo">
					</div>
					<div class="middle aligned content">
						<p><div class="ui small header white-text trajan">Republic of the Philippines</div></p>
						<p><div class="ui large header white-text trajan">Philippine Statistics Authority</div></p>
						<p><div class="ui medium header white-text trajan">Samar</div></p>
					</div>
				</div>
			</div>
		</div>
		<div class="ui basic segment right floated">
			<div class="ui items">
				<div class="header middle aligned">adasasd</div>
			</div>
		</div>
	</div>
</div> -->
<style>
	.ui.circular.popup {
	    border-radius: 50% !important;
	    text-align: center;
	    overflow: hidden !important;
	    display: flex;
	    justify-content: center;
	    align-items: center;
	}
</style>
<br><br>
<div class="ui grid centered psa-grey">
	<div class="sixteen wide mobile fifteen wide tablet fourteen wide computer thirteen wide large screen column">
		<div class="ui basic segment center aligned">
			<div class="ui text small gray-text">Copyright © 2025 <a class="white-text pointered dev_card">Grenjo</a>. All Rights Reserved</div>
		</div>
	</div>
	<div class="ui circular icon dropdown button teal bottom right pointing actions_drop floater-button" id="time_manager_tab_actions">
	<!-- <div class="ui dropdown labeled icon top pointing right "> -->
	    <i class="cog large icon loading"></i>
	    <!-- <i class="ellipsis horizontal large icon"></i> -->
	    <div class="menu">
	        <div class="ui center aligned teal tiny header">
	            <i class="large cogs icon"></i>
	            Time Manager Actions
	        </div>
	        <div class="item new_client_activator" id="new_client_activator">
                <i class="edit outline icon"></i>
                <small>Create Time Profile</small>
            </div>
            <div class="item new_profile_activator" id="new_profile_activator">
                <i class="user plus icon"></i>
                <small>Create New Child Profile</small>
            </div>
            <div class="item tm_reports_activator" id="tm_reports_activator">
                <i class="chart bar icon"></i>
                <small>Reports</small>
            </div>
            <div class="item tm_reports_activator" id="tm_logs_activator">
                <i class="history icon"></i>
                <small>Logs</small>
            </div>
            <!-- <div class="item add_item_activator" id="add_item_activator">
                <i class="orange archive icon"></i>
                <small>Archived Clients</small>
            </div> -->
	    </div>
	</div>
	<div class="ui circular icon dropdown button blue bottom right pointing actions_drop floater-button" id="pos_tab_actions">
	<!-- <div class="ui dropdown labeled icon top pointing right "> -->
	    <i class="cog large icon loading"></i>
	    <!-- <i class="ellipsis horizontal large icon"></i> -->
	    <div class="menu">
	        <div class="ui center aligned blue tiny header">
	            <i class="large cogs icon"></i>
	            POS Actions
	        </div>
	        <div class="item new_pos_item_activator" id="new_pos_item_activator">
                <i class="plus icon"></i>
                <small>New Item</small>
            </div>
            <div class="item pos_restocking_activator" id="pos_restocking_activator">
                <i class="dolly icon"></i>
                <small>Restocking</small>
            </div>
            <div class="item pos_checkouts_activator" id="pos_checkouts_activator">
                <i class="clipboard list icon"></i>
                <small>Checkouts</small>
            </div>
            <!-- <div class="item tm_reports_activator" id="pos_reports_activator">
                <i class="chart bar icon"></i>
                <small>Reports</small>
            </div> -->
            <div class="item tm_reports_activator" id="pos_logs_activator">
                <i class="history icon"></i>
                <small>Logs</small>
            </div>
            <!-- <div class="item add_item_activator" id="add_item_activator">
                <i class="orange archive icon"></i>
                <small>Archived Clients</small>
            </div> -->
	    </div>
	</div>
	<div class="ui circular icon dropdown button green bottom right pointing actions_drop floater-button" id="supply_tab_actions">
	<!-- <div class="ui dropdown labeled icon top pointing right "> -->
	    <i class="cog large icon loading"></i>
	    <!-- <i class="ellipsis horizontal large icon"></i> -->
	    <div class="menu">
	        <div class="ui center aligned green tiny header">
	            <i class="large cogs icon"></i>
	            Inventory Actions
	        </div>
	        <div class="item new_supply_item_activator" id="new_supply_item_activator">
                <i class="plus icon"></i>
                <small>New Item</small>
            </div>
            <div class="item supply_restocking_activator" id="supply_restocking_activator">
                <i class="dolly icon"></i>
                <small>Restocking</small>
            </div>
            <div class="item supply_checkouts_activator" id="supply_checkouts_activator">
                <i class="clipboard list icon"></i>
                <small>Checkouts</small>
            </div>
            <!-- <div class="item tm_reports_activator" id="supply_reports_activator">
                <i class="chart bar icon"></i>
                <small>Reports</small>
            </div> -->
            <div class="item tm_reports_activator" id="supply_logs_activator">
                <i class="history icon"></i>
                <small>Logs</small>
            </div>
            <!-- <div class="item add_item_activator" id="add_item_activator">
                <i class="orange archive icon"></i>
                <small>Archived Clients</small>
            </div> -->
	    </div>
	</div>
</div>
<style type="text/css">
	main {
        min-height: 100vh !important;
        margin: 0;
        display: grid;
        grid-template-rows: auto 1fr auto;
    }
    .royal_text {
    	color: royalblue !important;
    }
</style>
<script type="text/javascript">
	$('.dev_card').popup({
		on         : 'click',
		transition : 'drop',
		position   : 'top center',
		inline     : true,
		variation  : 'circular inverted',
		html       : `
			<img src="<?php echo base_url();?>dev_data/logo_small.png" class="ui small circular image">
		`
	});
</script>