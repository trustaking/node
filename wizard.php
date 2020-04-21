<?php 
require('include/initialise.php');

// Check session is live
if ( $_SESSION['session'] != 'Open' ) {
    $functions->web_redirect ("index.php");
}

$address = $coinFunctions->getColdStakingAddress("Hot");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="apple-mobile-web-app-title" content="Trustaking.com">
    <title>Trustaking Setup Wizard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='https://bootswatch.com/4/darkly/bootstrap.css'>
    <link rel='stylesheet' href='assets/css/wizard.css'>
    <script>window.console = window.console || function (t) { }; </script>
    <script> if (document.location.search.match(/type=embed/gi)) {window.parent.postMessage("resize", "*");} </script>
</head>

<body translate="no">
    <form method="POST" action="">
        <div class="container">
            <div id="app">
                <step-navigation :steps="steps" :currentstep="currentstep"> 
                </step-navigation>
                
                <div v-show="currentstep == 1">
                    <h3>Requirements</h3>
                    <div class="form-group">
                        <ul>
                            <li>Download a Core Wallet that supports Cold Staking <a href="https://github.com/thecrypt0hunter/CoreWallet/releases" target="_blank">here</a></li><br>
                            <li>Ensure your Core wallet is synced up to 100% <br><img src="images/cold-stake/sync-indicator.png"></li><br>
                            <li>Ensure you have some coins in your main wallet account (DASHBOARD)</li>
                        </ul>
                    </div>
                </div>
                
                <div v-show="currentstep == 2">
                    <h3>Core Wallet</h3>
                    <div class="form-group">
                        <ul>
                            <li> In your Core wallet, click into to COLD/DELEGATED STAKING tab.</li><br>
                                <img src="images/cold-stake/delegated-staking-tab.png"><br><br>
                            <li> Next click SETUP NOW.</li><br>
                                <img src="images/cold-stake/cold-staking-wallet.png">
                        </ul>
                    </div>
                </div>

                <div v-show="currentstep == 3">
                    <h3>Delegate Staking</h3>
                        <form>

                            <div class="form-row">

                                <div class="col">
                                    <div class="md-form mt-0">
                                        Complete the delegated staking setup form:<br><br>
                                        <img src="images/cold-stake/setup-delegated-staking.png">
                                    </div>
                                </div>

                                <div class="col">

                                    <div class="md-form mt-0">
                                    <br><br><br>

                                                <label class="float-left"> Here is your Trustaking Delegated Wallet Address:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" disabled value="<?php echo $address; ?>" id="address">
                                                    <button class="btn btn-primary" onclick="copyAddress()">copy</button>
                                                </div>
                                                <small id="addressHelpBlock" class="form-text text-muted">Feel free to make a note of it as you can use it for further deposits in the future.</small>
                                            </div>
                                    </div>
                                </div>
                            </div>
                

                <div v-show="currentstep == 4">
                    <h3>Step 4</h3>
                    <div class="form-group">
                        <li> Your Cold Staking setup is complete!</li><br>
                            <img src="images/cold-stake/cold-staking-sent.png"> <br>
                        <li> That's it! After 1 network confirmation your Cold Staking balance will be visible and will begin to stake after it matures.</li><br>
                            <img src="images/cold-stake/cold-staking-confirmed.png">
                    </div>
                </div>


                <step v-for="step in steps" :currentstep="currentstep" :key="step.id" :step="step"
                    :stepcount="steps.length" @step-change="stepChanged">
                </step>
                
                <script type="x-template" id="step-navigation-template">
                    <ol class="step-indicator">
                       <li v-for="step in steps" is="step-navigation-step" :key="step.id" :step="step" :currentstep="currentstep">
                       </li>
                    </ol>
               </script>
                
               <script type="x-template" id="step-navigation-step-template">
                    <li :class="indicatorclass">
                        <div class="step"><i :class="step.icon_class"></i></div>
                        <div class="caption hidden-xs hidden-sm">Step <span v-text="step.id"></span>: <span v-text="step.title"></span></div>
                    </li>
                </script>
                
                <script type="x-template" id="step-template">
                    <div class="step-wrapper" :class="stepWrapperClass">
                        <button type="button" class="btn btn-primary" @click="lastStep" :disabled="firststep"> Back </button>
                        <button type="button" class="btn btn-primary" @click="nextStep" :disabled="laststep"> Next </button>
                        <button type="submit" class="btn btn-primary" v-if="laststep"> Submit </button>
                    </div>
                </script>
            </div>
        </div>
    </form>

    <script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-157cd5b220a5c80d4ff8e0e70ac069bffd87a61252088146915e8726e5d9f147.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.4/vue.js'></script>
    <script id="rendered-js">

        Vue.component("step-navigation-step", {
            template: "#step-navigation-step-template",

            props: ["step", "currentstep"],

            computed: {
                indicatorclass() {
                    return {
                        active: this.step.id == this.currentstep,
                        complete: this.currentstep > this.step.id
                    };

                }
            }
        });

        Vue.component("step-navigation", {
            template: "#step-navigation-template",

            props: ["steps", "currentstep"]
        });

        Vue.component("step", {
            template: "#step-template",

            props: ["step", "stepcount", "currentstep"],

            computed: {
                active() {
                    return this.step.id == this.currentstep;
                },

                firststep() {
                    return this.currentstep == 1;
                },

                laststep() {
                    return this.currentstep == this.stepcount;
                },

                stepWrapperClass() {
                    return {
                        active: this.active
                    };

                }
            },

            methods: {
                nextStep() {
                    this.$emit("step-change", this.currentstep + 1);
                },

                lastStep() {
                    this.$emit("step-change", this.currentstep - 1);
                }
            }
        });

        new Vue({
            el: "#app",

            data: {
                currentstep: 1,

                steps: [
                    {
                        id: 1,
                        title: "Requirements",
                        icon_class: "fa fa-user-circle-o"
                    },

                    {
                        id: 2,
                        title: "Core Wallet",
                        icon_class: "fa fa-th-list"
                    },                   
                    
                    {
                        id: 3,
                        title: "Delegate Staking",
                        icon_class: "fa fa-th-list"
                    },

                    {
                        id: 4,
                        title: "Submit",
                        icon_class: "fa fa-paper-plane"
                    }]
            },


            methods: {
                stepChanged(step) {
                    this.currentstep = step;
                }
            }
        });

        function copyAddress() {
        var copyText = document.getElementById("address");
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/
        document.execCommand("copy");
        alert("Copied the text: " + copyText.value);
        }

    </script>
</body>
</html>