export class ConversionUtils {
    static UTCtoLocalDate(utcDate) {
        // Appending 'Z' indicates UTC time
        const date = new Date(utcDate + 'Z');
        return date.toLocaleString();
    }
}
