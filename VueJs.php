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
    <style>
        .container{
            width: 70%;
            margin-left: 15%;
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
        <my-form></my-form><br /><br /><br />
        <el-switch
                style="display: block"
                v-model="value4"
                active-color="#13ce66"
                inactive-color="#ff4949"
                active-text="Show Table"
                inactive-text="Hide Table">
        </el-switch>
        <div v-show = "value4">
            <my-table></my-table>
        </div>
    </div>
</div>

<!-- import Vue before Element -->
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<!-- import JavaScript -->
<script src="https://unpkg.com/element-ui/lib/index.js"></script>

<!-- Component define -->
<script type="text/x-template" id="new-form">
        <el-form :model="ruleForm2" status-icon :rules="rules2" ref="ruleForm2" label-width="120px" class="demo-ruleForm">
            <el-form-item label="Limit of records" prop="limit">
                <el-input placeholder="Enter limit of records to show" v-model.number="ruleForm2.limit" style="width:50%;"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitForm('ruleForm2')">Submit</el-button>
                <el-button @click="resetForm('ruleForm2')">Reset</el-button>
            </el-form-item>
        </el-form>
</script>
<script type="text/x-template" id="new-table">
    <el-table
            :data="tableData"
            :page-size="2"
            :pagination-props="{ pageSizes: [5, 10, 20] }"
            stripe
            style="width: 100%">
        <el-table-column
                prop="id"
                label="ID"
                width="180">
        </el-table-column>
        <el-table-column
                prop="name"
                label="Name"
                width="180">
        </el-table-column>
        <el-table-column
                prop="email"
                label="Email">
        </el-table-column>
        <el-table-column
                prop="created_at"
                label="Created Date">
        </el-table-column>
    </el-table>
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    var ExampleForm = {
        template: '#new-form',
        data() {
            var checkLimit = (rule, value, callback) => {
                if (!value) {
                    return callback(new Error('Please input the limit'));
                }
                setTimeout(() => {
                    if (!Number.isInteger(value)) {
                    callback(new Error('Please input digits'));
                } else {
                        if (value < 1) {
                            callback(new Error('Limit must be greater than 1'));
                        } else {
                            callback();
                        }
                    }
                }, 1000);
            };
            return {
                ruleForm2: {
                    limit: ''
                },
                rules2: {
                    limit: [
                        { validator: checkLimit, trigger: 'blur' }
                    ]
                }
            };
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        $.get("index.php?limit=limit "+this.ruleForm2.limit, function(result){
                            console.log(result);
                            nVue.$children[2].tableData = JSON.parse(result);
                        });

                    } else {
                        console.log('error submit!!');
                return false;
            }
            });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
                $.get("index.php?limit=", function(result){
                    console.log(result);
                    nVue.$children[2].tableData = JSON.parse(result);
                });
            }
        }
    }
    var ExampleTable = {
        template: '#new-table',
        data() {
            return {
                tableData: <?php echo json_encode($userData)?>
            }
        }
    }
    var nVue = new Vue({
        el: '#app',
        components: {
            // <my-component> will only be available in parent's template
            'my-form' : ExampleForm,
            'my-table' : ExampleTable
        },
        data: function() {
            return {
                value4: true
            }
        }
    })
</script>

</body>
</html>