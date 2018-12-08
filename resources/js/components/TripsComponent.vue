<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">My Trips</div>

                    <div class="card-body">
                        <button class="btn btn-sm">New Trip</button>
                        <button class="btn btn-sm btn-success" :click="startDiction">Speak Command</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
          startDiction: function(){
              if (window.hasOwnProperty('webkitSpeechRecognition')) {

              var recognition = new webkitSpeechRecognition();

              recognition.continuous = false;
              recognition.interimResults = false;

              recognition.lang = "en-US";
              recognition.start();

              recognition.onresult = function(e) {
                var results = e.results[0][0].transcript;
                recognition.stop();
                console.log(results[0])
              };

              recognition.onerror = function(e) {
                recognition.stop();
              }

            }
          }
        }
    }
</script>
