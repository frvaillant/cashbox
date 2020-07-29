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
        let hour = (date.getHours() < 10) ? '0' + date.getHours() : date.getHours()
        let min = (date.getMinutes() < 10) ? '0' + date.getMinutes() : date.getMinutes()
        let sec = (date.getSeconds() < 10) ? '0' + date.getSeconds() : date.getSeconds()
        return hour + ':' + min + ':' + sec
    }

    getDateTime () {
        return this.getDate() + '. Il est ' + this.getTime()
    }

    render() {
        if(this.renderZone) {
            this.renderZone.innerHTML = this.getDateTime()
        }
    }

    isInstanciable() {
        return (this.renderZone) ? true : false
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const timer = new Timer('clock')
    if (timer.isInstanciable()) {
        window.setInterval(() => {
            timer.render()
        }, 1000)
    }
})
