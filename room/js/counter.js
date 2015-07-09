$(document).ready(function(){
    "use strict";
    


    var intval = function (mixed_var, base) {var tmp;var type = typeof(mixed_var);if (type === 'boolean') {return +mixed_var;} else if (type === 'string') {tmp = parseInt(mixed_var, base || 10);return (isNaN(tmp) || !isFinite(tmp)) ? 0 : tmp;} else if (type === 'number' && isFinite(mixed_var)) {return mixed_var | 0;} else {return 0;}};
    var rand = function(numLow, numHigh) {var adjustedHigh = (parseFloat(numHigh) - parseFloat(numLow)) + 1;return Math.floor(Math.random()*adjustedHigh) + parseFloat(numLow);};
    

    var timeouts = [];
    var clearTimeouts = function() {
        for (var i = 0; i < timeouts.length; i++) {
            window.clearTimeout(timeouts[i]);
        }
    };
    
 
    
    var createCountdown = function(){
        
        // Countdown Class
        function Countdown() {
            var _this   = this;
            var countdown = $('.countdown');
            var date;
            var time;
            var styleType = 'block';
            this.debug  = false;
            this.daysChart = null;
            this.hoursChart = null;
            this.minutesChart = null;
            this.secondsChart = null;

            //init application
            this.init = function() {
                if (countdown.length === 0) {return;}

                // Get the date
                date = countdown.attr('date');
                time = countdown.attr('time');
                date = date.split('-');
                time = time.split(':');
                var styletypeAttr = countdown.attr('style-type');
                if (typeof styletypeAttr == "string") {
                    styleType = styletypeAttr;
                }

                // Invalid date format
                if (date.length !== 3) {return;}
                if (time.length !== 3) {return;}

                // Set the actual date                
                var now = new Date();                
                var localTimeZoneOffset = now.getTimezoneOffset();
                var timeZonesDiff = (localTimeZoneOffset - 180)*(60*1000);
                var serverDate = new Date(intval(date[0]), intval(date[1]) - 1, intval(date[2]),intval(time[0]),intval(time[1]),intval(time[2]));
                date = new Date(serverDate - timeZonesDiff);
                
                if(styleType == "block") {
                    // Add the necessary HTML
                    $('.countdown').html( 
                          '<div class="row">' +
                          '<div class="col-md-3 col-xs-3">' +                        
                            '<div id="days" class="info"><div class="number">1</div><p class="days-string">days</p></div>' +
                          '</div>' +
                          '<div class="col-md-3 col-xs-3">' +                        
                            '<div id="hours" class="info"><div class="number">1</div><p class="hours-string">hours</p></div>' +
                          '</div>' +
                          '<div class="col-md-3 col-xs-3">' +                        
                            '<div id="minutes" class="info"><div class="number">1</div><p class="mins-string">mins</p></div>' +
                          '</div>' +
                          '<div class="col-md-3 col-xs-3">' +                        
                            '<div id="seconds" class="info"><div class="number">1</div><p class="secs-string">secs</p></div>' +
                          '</div>' +
                        '</div>' );
                } else {
                    $('.countdown').html( 
                          '<div class="row">' +
                          '<div class="col-md-3 col-xs-3">' +                        
                            '<div id="days" class="info"><span class="number">1</span><span class="days-string"> days</span></div>' +
                          '</div>' +
                          '<div class="col-md-3 col-xs-3">' +                        
                            '<div id="hours" class="info"><span class="number">1</span><span class="hours-string"> hours</span></div>' +
                          '</div>' +
                          '<div class="col-md-3 col-xs-3">' +                        
                            '<div id="minutes" class="info"><span class="number">1</span><span class="mins-string"> mins</span></div>' +
                          '</div>' +
                          '<div class="col-md-3 col-xs-3">' +                        
                            '<div id="seconds" class="info"><span class="number">1</span><span class="secs-string"> secs</span></div>' +
                          '</div>' +
                        '</div>' );
                }

                //at start update counter
                this.checkDate();

                //every 1 sec update counter
                timeouts[timeouts.length] = window.setInterval(function() {
                    _this.checkDate();
                }, 1000);
            };

            //counter update function
            this.checkDate = function() {
                //get actually date
                var now = new Date();                
                //get difference from launch date (declared in head in index.html)
                var diff = date.getTime() - now.getTime();
                
                //change multisecond result to seconds, minutes, hours and days
                var tmp = diff / 1000;
                var seconds = Math.floor(tmp % 60);
                tmp /= 60;
                var minutes = Math.floor(tmp % 60);
                tmp /= 60;
                var hours = Math.floor(tmp % 24);
                tmp /= 24;
                var days = Math.floor(tmp);
                
                var spelling = {
                    days:    [countdown.attr('day') ? countdown.attr('day') : "day", countdown.attr('days') ? countdown.attr('days') : "days"],
                    hours:   [countdown.attr('hour') ? countdown.attr('hour') : "hour", countdown.attr('hours') ? countdown.attr('hours') : "hours"],
                    minutes: [countdown.attr('minute') ? countdown.attr('minute') : "min", countdown.attr('minutes') ? countdown.attr('minutes') : "mins"],
                    seconds: [countdown.attr('second') ? countdown.attr('second') : "sec", countdown.attr('seconds') ? countdown.attr('seconds') : "secs"],
                };
                
                if (diff < 0) {
                                       
                } else {
                    //render in text
                    $("#days .number").html(days);
                    $("#hours .number").html(hours);
                    $("#minutes .number").html(minutes);
                    $("#seconds .number").html(seconds);

                    $("#days > .days-string").html(days === 1 ? spelling.days[0] : spelling.days[1]);
                    $("#hours > .hours-string").html(hours === 1 ? spelling.hours[0] : spelling.hours[1]);
                    $("#minutes > .mins-string").html(minutes === 1 ? spelling.minutes[0] : spelling.minutes[1]);
                    $("#seconds > .secs-string").html(seconds === 1 ? spelling.seconds[0] : spelling.seconds[1]);
                }
            };
        }
        
        // Redraw the character
        var recreateCharacter = function(){
            clearTimeouts();
            var countdown = new Countdown(); 
            countdown.init();
        };
        
        var resizeParallax = function() {
            if (intval($(window).width()) >= 768) {
                $('section.parallax').css(
                    'marginTop', 
                    intval($('section.fixed').outerHeight()) + 'px'
                );
            } else {
                $('section.parallax').css(
                    'marginTop', 
                    'auto'
                );
            }
        };
        
        
        timeouts[timeouts.length] = window.setTimeout(recreateCharacter, 500);
        $(window).resize(function(){
            recreateCharacter();
            resizeParallax();
        });
    };
    
    createCountdown();
    //$("#loginModal").modal('show');
    
});
