// Progress Ring

const progressRing = {
    ring: document.querySelector('.cercle-bleu'),
    indicator: document.getElementById('indicateur-etape'),
    totalSteps: 8,
    currentStep: etapeCourante,
    radius: 32,
    get circumference() {
        return 2 * Math.PI * this.radius;
    },
    init() {        
        this.ring.style.strokeDasharray = this.circumference;
        this.ring.style.strokeDashoffset = this.circumference;
        this.ring.style.transition = "stroke-dashoffset 2s ease";
        this.indicator.classList.add('tourner-indicateur');
        requestAnimationFrame(() => {
            this.setStep(1);
        });
    },
    setStep(step, resultat) {
        this.currentStep = step;
        const percent = (step - 1) / (this.totalSteps - 1);
        const offset = this.circumference * (1 - percent);
        this.ring.style.strokeDashoffset = offset;
        if (step === 1) {
            this.indicator.innerHTML = `<i class="bi bi-arrow-down-up"></i>`;
            this.indicator.classList.add('tourner-indicateur');
        } else if (step === 8) {
            this.indicator.classList.remove('tourner-indicateur');
            this.indicator.classList.remove('rotate-animation');
            this.indicator.innerHTML = `<i class="bi bi-check-lg"></i>`;
            if (resultat === 'succes') {
                this.ring.style.stroke = '#20f800'
                this.indicator.style.color = '#007e2b' 
            } else {
                this.ring.style.stroke = '#ff5151';
                this.indicator.style.color = '#9e0000';
            }
        } else {
            this.indicator.classList.remove('tourner-indicateur');
            this.ring.style.transition = "stroke-dashoffset 0.5s ease";
            this.indicator.textContent = `${step - 1} / ${this.totalSteps - 2}`;
        }
    }
}

function soumissionProgress() {
    const ring = document.querySelector('.cercle-bleu');
    const texte = document.getElementById('texte-etape');

    ring.classList.add('rotate-animation');
    texte.textContent = "Envoi en cours...";
}

progressRing.init();