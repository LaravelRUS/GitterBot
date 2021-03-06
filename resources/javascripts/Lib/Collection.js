/**
 * Collection
 */
export default class Collection {
    /**
     * Items
     */
    items = ko.observableArray([]);

    /**
     * @constructor
     */
    constructor(items = []) {
        this.items(items);
    }

    /**
     * @param model
     * @returns {Collection}
     */
    of(model) {
        var result = [];
        this.items().forEach(item => {
            result.push(new model(item));
        });
        return new Collection(result);
    }

    /**
     * @param item
     * @returns {Collection}
     */
    add(item) {
        this.items.push(item);
        return this;
    }

    /**
     * @param callback
     * @returns {Collection}
     */
    find(callback) {
        var result = [];
        this.items().forEach(item => {
            if (callback(item)) {
                result.push(item);
            }
        });
        return new Collection(result);
    }

    /**
     * @param callback
     * @returns {Collection}
     */
    remove(callback) {
        this.items.remove(callback);
        return this;
    }

    /**
     * @returns {Collection}
     */
    clear() {
        this.items([]);
        return this;
    }

    /**
     * @param shift
     * @returns {Blob|ArrayBuffer|Array.<T>|string|*}
     */
    first(shift = 0) {
        return this.items().slice(shift, 1)[0];
    }

    /**
     * @param callback
     * @param order
     * @return {Collection}
     */
    sort(callback, order = 1) {
        order = order > 0 ? 1 : -1;

        return new Collection(this.items().sort((a, b) => {
            a = callback(a);
            b = callback(b);
            if (a === b) {
                return 0;
            }
            return a > b
                ? order
                : -order;
        }));
    }

    /**
     * @param callback
     * @returns {Collection}
     */
    each(callback) {
        this.items().forEach(item => {
            callback(item);
        });
        return this;
    }

    /**
     * @param count
     * @returns {Collection}
     */
    take(count) {
        return new Collection(this.items().slice(0, count));
    }

    /**
     * @param callback
     * @returns {Collection}
     */
    map(callback) {
        return new Collection(this.items().map(item => callback(item)));
    }

    /**
     * @returns {*}
     */
    toArray() {
        return this.items();
    }

    /**
     * @returns {*}
     */
    toObservableArray() {
        return this.items;
    }

    /**
     * @returns {*}
     */
    get length() {
        return this.items().length;
    }

    /**
     * @returns {*}
     */
    *[Symbol.iterator]() {
        for (var i = 0; i < this.length; i++) {
            yield this.items()[i];
        }
    }
}