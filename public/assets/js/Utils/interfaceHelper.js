export class InterfaceHelper {
    static isInterface(obj, interfaceObj) {
        return JSON.stringify(obj) === JSON.stringify(interfaceObj);
    }
}
