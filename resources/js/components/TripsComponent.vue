<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">My Trips</div>

                    <div class="card-body">
                        <button class="btn btn-sm" v-on:click="planTripModal()">New Trip</button>
                        <button class="btn btn-sm btn-success" v-on:click="startDiction">Speak Command</button>
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Start Date</th>
                              <th>End Date</th>
                              <th>Budget</th>
                              <th>City</th>
                              <th>State</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="trip in me.trips">
                              <td>{{trip.start_date.date}}</td>
                              <td>{{trip.end_date.date}}</td>
                              <td>{{trip.budget}}</td>
                              <td>{{trip.city}}</td>
                              <td>{{trip.state}}</td>
                              <td>
                                <button class="btn btn-xs" v-on:click="getAtms(trip)">ATM</button>

                                <button class="btn btn-sm btn-info" v-on:click="analyzeTrip(trip)">Analyze Trip</button>
                                <button class="btn btn-sm btn-info" v-on:click="getOffers(trip)">Show Offers</button>
                                <button class="btn btn-sm btn-danger" v-on:click="deleteTrip(trip)">Delete Trip</button>
                              </td>
                            </tr>
                          </tbody>
                        </table>
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
                <h4 class="modal-title">Plan A New Trip</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <input class="form-control" type="date" v-model="trip.start_date" placeholder="Start Date">
                  <input type="date" class="form-control" v-model="trip.end_date" placeholder="End Date">
                  <input type="number" placeholder="Budget"  class="form-control" v-model="trip.budget">
                  <input type="text" placeholder="City" v-model="trip.city" class="form-control">
                  <input type="text" placeholder="State" v-model="trip.state" class="form-control">
                  <button class="btn btn-sm" v-on:click="addTrip()">Add Trip</button>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                <h4 class="modal-title">ATM Locator</h4>
              </div>
              <div class="modal-body">
                <p>
                  Latitude: {{coords.latitude}}
                <br>
                  Longitude: {{coords.longitude}}
                  <GmapMap
                  :center="{lat:coords.latitude, lng:coords.longitude}"
                  :zoom="7"
                  map-type-id="terrain"
                  style="width: 500px; height: 300px"
                >
                <GmapMarker
                :key="index"
                v-for="(m, index) in markers"
                :position="m.position"
                :clickable="true"
                :draggable="true"
                @click="center=m.position"
              />

                </GmapMap>
              </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>

        <!-- Modal -->
        <div id="offerModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Offers</h4>
              </div>
              <div class="modal-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Offer</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="offer in me.offers">

                      <td>{{offer}}</td>
                    
                    </tr>
                  </tbody>
                </table>

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
            latitude: 0.00,
            longitude: 0.00,
          },
          markers: [],
          trip:{},
          me: {},
          offers: []
          }
        },
        created(){
          var that = this;
          axios.get('/api/user').then(data =>{
            that.me = data.data.data;
          })
        },
        methods:{
          getAtms: function(trip){
            var map;
            this.coords.latitude = parseFloat(trip.lat);
            this.coords.longitude = parseFloat(trip.long);
            /*this.markers.push({
              position:{lat:parseFloat(position.coords.latitude),long:parseFloat(position.coords.longitude)}
            });*/
            axios.get('/api/ATMs/'+this.coords.latitude + '/' + this.coords.longitude + '/20').then(data => {
              console.log(data.data);
              var atms = data.data;
              for(var i = 0; i < atms.length; ++i){
                this.markers.push({
                  position:{
                    lat:parseFloat(atms[i].latitude),
                    lng:parseFloat(atms[i].longitude),
                    label: atms[i].name}
                });
              }

            })
            $("#atmModal").modal();
          },
          deleteTrip: function(index){
            var that = this;
            axios.delete('/api/trip/'+that.me.trips[index].id).then(data =>{
              that.me.trips.splice(1,index);
            })
          },
          analyzeTrip: function(trip){
            var budget = trip.budget/trip.duration
            var synth = window.speechSynthesis;
            var utterThis = new SpeechSynthesisUtterance("You have a budget of " + trip.budget+ 'dollars. Your trip has a duration of '+ trip.duration+ 'days. Therefore you can spend '+ budget.toFixed(2) + 'a day. Would you like to see offers in your area?');
            synth.speak(utterThis);
            var commands = [ 'yes','no'];
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
              var that = this;
              recognition.onresult = function(e) {
                var results = e.results[0][0].transcript;
                recognition.stop();
                console.log('Results',results);
                if(results == 'yes'){
                  that.showOffers();
                }
              }


          }
        },
          showOffers: function(){
            alert('showing offers!');
          },
          getTrips: function(){
            var that = this;
            axios.get('/api/trip').then(data=>{
              that.trips = data.data;
              $("#tripModal").modal();
            });
          },
          addTrip: function(){

            var that = this;
            var geocoder =  new google.maps.Geocoder()
            geocoder.geocode( { 'address': this.trip.city + ',' + this.trip.state}, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {

                that.trip.lat = results[0].geometry.location.lat();
                that.trip.long = results[0].geometry.location.lng();
                console.log(that.trip);
              } else {
                alert("Something got wrong " + status);
              }
            });
            console.log(that.trip);
            axios.post('/api/trip',that.trip).then(data => {
              console.log(data.data);
                that.me.trips.push(data.data);
            });
          },
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
              var that = this;
              recognition.onresult = function(e) {
                var results = e.results[0][0].transcript;
                recognition.stop();
                console.log('Results',results);
                switch(results){
                  case 'plan a trip':
                   that.planTripModal();
                   break;
                   case 'find an ATM':
                   that.getLocation();
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

          getLocation: function() {
            console.log('Getting location....')
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(this.showPosition);
            } else {
              alert('Error!');
            }
          },

          showPosition: function(position) {
            var map;
            this.coords.latitude = position.coords.latitude;
            this.coords.longitude = position.coords.longitude;
            this.markers.push({
              position:{lat:parseFloat(position.coords.latitude),lng:parseFloat(position.coords.longitude)}
            });
            axios.get('/api/ATMs/'+this.coords.latitude + '/' + this.coords.longitude + '/20').then(data => {
              console.log(data.data);
              var atms = data.data;
              for(var i = 0; i < atms.length; ++i){
                this.markers.push({
                  position:{
                    lat:parseFloat(atms[i].latitude),
                    lng:parseFloat(atms[i].longitude),
                    label: atms[i].name
                  }
                });
              }

            })
            $("#atmModal").modal();
          },
          planTripModal: function(){

            $("#tripModal").modal();
          },
          getOffers:function(trip){
            var that = this;
            axios.post('/api/offers/'+trip.lat+'/'+trip.long).then(data => {
              that.offers = data.data;
            })
          }
        }
    }
</script>
<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 80%;
      }

    </style>
