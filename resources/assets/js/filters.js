Vue.prototype.filters = {
    currency(value) {
        return accounting.formatMoney(value);
    },

    time(value) {
        var time = value.split(':');

        var hours = Number(time[0]);

        var minutes = Number(time[1]);

        var amPm;

        switch(true) {
            case (hours == 0):
                hours = 12;

                amPm = 'AM';
                break;
            case (hours == 12):
                amPm = 'PM';
                break;
            case (hours > 12):
                hours = hours - 12;

                amPm = 'PM';
                break;
        }

        return hours + ':' + minutes + ' ' + amPm;
    },

    dishDate(value) {
        var date = value.split('-');

        var year = date[0];

        var month = date[1];

        var day = date[2];

        return [month,day,year].join('-');
    }
};