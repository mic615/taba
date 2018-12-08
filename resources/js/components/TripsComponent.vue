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
        <!-- Modal -->
        <div id="atmModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Plan A New Trip</h4>
              </div>
              <div class="modal-body">
                <p>Some text in the modal.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
        <!-- Modal -->
        <div id="tripModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ATM Locator</h4>
              </div>
              <div class="modal-body">
                <p>
                  Latitude: {{coords.latitude}}
                <br>
                  Longitude: {{coords.longitude}}
              </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
        data(){
          return{
            coords: {
            latitude: '',
            longitude: ''
          }
          }
        },
        methods:{
          startDiction: function(){
            var commands = [ 'plan a trip' , 'show me my trips' , 'find an ATM', 'show my transactions', 'what is my balance'];
            var grammar = '#JSGF V1.0; grammar colors; public <command> = ' + commands.join(' | ') + ' ;'
              if (window.hasOwnProperty('webkitSpeechRecognition') || window.hasOwnProperty('SpeechRecognition')) {

              var recognition = new webkitSpeechRecognition() || new SpeechRecognition();
              var speechRecognitionList =  new webkitSpeechGrammarList();
              speechRecognitionList.addFromString(grammar, 1);
              recognition.grammars = speechRecognitionList;
              recognition.continuous = false;
              recognition.interimResults = false;
              console.log('Grammars',recognition.grammars);

              recognition.lang = "en-US";
              recognition.start();

              recognition.onresult = function(e) {
                var results = e.results[0][0].transcript;
                recognition.stop();
                console.log('Results',results);
                switch(results){
                  case 'plan a trip':
                   this.planTripModal();
                   break;
                   case 'find an atm':
                   this.getLocation();
                   break;
                   default:
                   alert('Cannot recognize command!')
                   break;
                }
              };

              recognition.onerror = function(e) {
                recognition.stop();
              }

            }
          },
          planTripModal: function(){
            $("#tripModal").modal();
          },
          getLocation: function() {
            console.log('Getting location....')
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(this.showPosition);
            } else {
              alert('Error!');
            }
          },

          showPosition: function(position) {

            this.coords.latitude = position.coords.latitude;
            this.coords.longitude = position.coords.longitude;
            $("#atmModal").modal();
          }
        }
    }
</script>
