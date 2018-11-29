<?php
$db = "test";
$db_pwd = "";
$db_user = "root";
$mysqli = new mysqli(getenv( "127.0.0.1" ), $db_user, $db_pwd, $db);
$limit = '';
if($mysqli){
    echo "Connection Created.";
} else {
    echo $mysqli->error;
}

$userData = getUserList($mysqli, $limit);
//print_r($userData);

function getUserList($mysqli, $limit) {
    $data = [];
    $query = $mysqli->query( "Select * from users ". $limit );
    if ( $query ) {
        while($row = mysqli_fetch_assoc($query)){
            array_push($data,$row);
        }
    } else {
        //print error message
        echo $mysqli->error;
    }
    return $data;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!-- import CSS -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        .container{
            width: 50%;
            margin-left: 25%;
            margin-top:10%;
        }
        .header-ul li {
            float: left;
            padding: 16px;
        }
        .header-ul li a {
            text-decoration: none;
            font-size: 18px;
            font-weight: 700;
        }
    </style>
</head>
<body>
<div id="app">
    <div class="container">
    <div>
        <ul class="header-ul" style="list-style-type:none">
            <li><a href="VueJs.php">Home</a></li>
            <li><a href="binding.php">Others</a></li>
            <li><a href="vueTable.php">Vue Table 2</a></li>
        </ul>
    </div><br /><br /><br />
        <my-table></my-table>
    </div>
</div>

<!-- import Vue before Element -->
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<!-- import JavaScript -->
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script src="vue-tables-2.min.js"></script>

<script type="text/x-template" id="recent-donations-table">
	<div>
		<v-client-table :columns="columns" :data="data" :options="options" v-loading="tableLoading" element-loading-text="Loading..." ref='table'>
		</v-client-table>
	</div>
</script>

<script type="text/javascript">
	Vue.use(VueTables.ClientTable);
	const Event = VueTables.Event ;
	var recentDonation = {
		template: '#recent-donations-table',
		data() {
			return {
				tableLoading:false,
				columns: ['id','name','email','created_at'],
				data: <?php print json_encode( $userData )?>,
				options: {
					texts:{
						count:'Showing {from} to {to} of {count} records|{count} records|One record',
						filter:'Filter Table:',
						filterPlaceholder:'Enter search text here',
						limit:'Records per Page:',
						noResults:'No matching records',
						page:'Page:', // for dropdown pagination
						filterBy: 'Filter by {column}', // Placeholder for search fields when filtering by column
						loading:'Loading...', // First request to server
						defaultOption:'Select {column}' // default option for list filters
					},
					columnsClasses:{'created_at':'column-nowrap','id':'column-nowrap'},
					headings: {
						id:'ID',
						name: 'Name',
						email: 'Email',
						created_at: 'Created Date'
					},
					sortable: ['id','created_at'],
					filterable: ["name","email"],
					perPageValues:[2,4,6,8],
					perPage:2,
					customFilters: [{
						name: 'customFilter',
					    callback: function (row, data) {

					    }
					}]
				}
			}
		},
		methods : {
		}
	};

    var nVue = new Vue({
        el: '#app',
        components: {
            // <my-component> will only be available in parent's template
            'my-table' : recentDonation
        },
        data: function() {
            return {
            }
        }
    })
</script>
</body>
</html>