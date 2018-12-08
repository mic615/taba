<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">My Trips</div>

                    <div class="card-body">
                        <button class="btn btn-sm">New Trip</button>
                        <button class="btn btn-sm btn-success" v-on:click="startDiction">Speak Command</button>
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
            var commands = [ 'plan a trip' , 'show me my trips' , 'find an atm near me', 'show my transactions', 'what is my balance'];
            var grammar = '#JSGF V1.0; grammar colors; public <command> = ' + commands.join(' | ') + ' ;'
              if (window.hasOwnProperty('webkitSpeechRecognition') || window.hasOwnProperty('SpeechRecognition')) {

              var recognition = new webkitSpeechRecognition() || new SpeechRecognition();
              var speechRecognitionList = new SpeechGrammarList() || new webkitSpeechGrammarList();
              speechRecognitionList.addFromString(grammar, 1);
              recognition.grammars = speechRecognitionList;
              recognition.continuous = false;
              recognition.interimResults = false;

              recognition.lang = "en-US";
              recognition.start();

              recognition.onresult = function(e) {
                var results = e.results[0][0].transcript;
                recognition.stop();
                console.log(results)
              };

              recognition.onerror = function(e) {
                recognition.stop();
              }

            }
          }
        }
    }
</script>
