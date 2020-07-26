class Timer {
    constructor(zoneId) {
        this.renderZone = document.getElementById(zoneId)
    }

    getDate() {
        const months = [
            "Janvier",
            "Février",
            "Mars",
            "Avril",
            "Mai",
            "Juin",
            "Juillet",
            "Août",
            "Septembre",
            "Octobre",
            "Novembre",
            "Décembre",
        ]
        const date = new Date();
        return date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear()
    }

    getTime() {
        const date = new Date();
        return date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds()
    }

    getDateTime () {
        return this.getDate() + '. Il est ' + this.getTime()
    }

    render() {
        this.renderZone.innerHTML = this.getDateTime()
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const timer = new Timer('clock')
    window.setInterval(() => {
        timer.render()
    },1000)
})
