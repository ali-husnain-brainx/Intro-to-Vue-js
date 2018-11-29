<html>
<head>
    <title>VueJs Instance</title>
    <!-- import Vue before Element -->
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <!-- import JavaScript -->
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <!-- import CSS -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <style>
        .container{
            width: 50%;
            margin-left: 25%;
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
        #databinding{
            width: 20%;
            margin-left: 40%;
        }
    </style>
</head>
<body>
<div id = "databinding">
    <div>
        <ul class="header-ul" style="list-style-type:none">
            <li><a href="VueJs.php">Home</a></li>
            <li><a href="binding.php">Others</a></li>
            <li><a href="vueTable.php">Vue Table 2</a></li>
        </ul>
    </div><br /><br /><br />
    <span>Computed Example:</span><br>
    <el-input v-model="changeTittle" style="width:100%;"></el-input>
    <br><br>
    {{title}}<br/>
    <a href = "hreflink" target = "_blank"> {{hrefTitle}} </a> <br/>
    <a href = "{{hreflink}}" target = "_blank">{{hrefTitle.toLowerCase()}} </a>  <br/>
    <a v-model="changeTittle" v-bind:href = "hreflink" target = "_blank">{{hrefTitleLowerCase}} </a>   <br/>
    <br>
    <span>Watch Example:</span><br>
    <el-input v-model="question" style="width:100%;"></el-input>
    <p>{{ answer }}</p>
    <br><br>
    <span>Mixin Example</span><br>
    <el-select v-model="value4" clearable placeholder="Select">
        <el-option
        v-for="item in stateList"
        :key="item.abbreviation"
        :label="item.name"
        :value="item.abbreviation">
        </el-option>
    </el-select>
</div>
<?php include 'mixin.states.php' ?>
<script type = "text/javascript">
    var vm = new Vue({
        el: '#databinding',
        mixins:[StatesMixin],
        data: {
            value4:'',
            changeTittle:"Click Me",
            title : "BINDING EXAMPLE",
            hrefTitle : 'Click Me',
            hreflink : "http://www.google.com",
            question: '',
            answer: 'I cannot give you an answer until you ask a question!'
        },
        watch: {
            // whenever question changes, this function will run
            question: function (val) {
                //this.answer = val.toUpperCase()
                this.answer = 'typing...'
            }
        },
        computed:{
            hrefTitleLowerCase: function () {
                return this.changeTittle.toUpperCase();
            }
        }
    });
</script>

</body>
</html>