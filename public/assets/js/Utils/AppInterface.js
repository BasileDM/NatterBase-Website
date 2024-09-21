import { ControlPanel } from '../Components/ControlPanel.js';
export class AppInterface {
    constructor() {
        this.controlPanel = new ControlPanel();
        this.bindEvents();
    }
    bindEvents() {
        console.log('binding AppInterface events');
    }
}
