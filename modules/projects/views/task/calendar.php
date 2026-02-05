<?php

use app\assets\FullcalendarAsset;
use yii\helpers\Url;

FullcalendarAsset::register($this);

$this->title = 'Naptár';

$this->registerJs("
    var calendarEl = document.getElementById('calendar');
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        allDaySlot: false,
        locale: 'hu',
        
        buttonText: {
            today: 'ma',
            month: 'hónap',
            week: 'hét',
            day: 'nap'
        },
        
        allDayText: 'egész nap',
        firstDay: 1, // Hétfő
        slotMinTime: '08:00:00',
        slotMaxTime: '16:30:00',
        hiddenDays: [0],    //Vasárnap nem kell
        
        expandRows: true,

        dayHeaderFormat: { 
            weekday: 'long',
            month: 'numeric',
            day: 'numeric',
            omitCommas: true
        },

        // Adatok lekérése a Yii2 controllerből
       events: {
            url: '" . Url::to(['/projects/task/calendar-data']) . "',
            method: 'GET',
            extraParams: function() {
                return {};
            },
            failure: function() {
                alert('Hiba az események betöltésekor!');
            }
       },
        datesSet: function(info) {
            console.log('Új időszak betöltve:', info.startStr, '-', info.endStr);
        },
        // Kattintás esemény
        eventClick: function(info) {
            // Itt nyitod meg a Modal-t
            // info.event.id tartalmazza a Task ID-t
            $('#taskModal').modal('show')
                .find('#modalContent')
                .load('" . Url::to(['/projects/task/view-ajax']) . "?id=' + info.event.id);
        }
    });

    calendar.render();

    window.mainCalendar = calendar;
");

?>

<div class="calendar-wrapper">
    <div id="calendar"></div>
</div>

<div class="modal fade" id="taskModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl task-modal" role="document">
        <div class="modal-content">
            <div id="modalContent">
                
            </div>
        </div>
    </div>
</div>