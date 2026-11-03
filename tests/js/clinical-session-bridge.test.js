import { test } from 'node:test';
import assert from 'node:assert/strict';
import { acceptsClinicalActivity } from '../../resources/js/clinical-session-bridge.js';

test('only accepts activity from the configured origin and registered live window', () => {
    const source = { closed: false };
    const windows = new Set([source]);
    const event = { origin: 'https://clinical.example', source, data: { type: 'clinical:activity:v1' } };
    assert.equal(acceptsClinicalActivity(event, event.origin, windows), true);
    for (const changed of [
        { origin: 'https://evil.example' },
        { source: { closed: false } },
        { source: null },
        { data: { type: 'anything' } },
        { data: null },
    ]) assert.equal(acceptsClinicalActivity({ ...event, ...changed }, event.origin, windows), false);
    source.closed = true;
    assert.equal(acceptsClinicalActivity(event, event.origin, windows), false);
});
