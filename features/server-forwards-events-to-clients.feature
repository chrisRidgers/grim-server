Feature:
    In order to syncronise between clients
    I need to be able send received events to all connected clients

    Scenario:
        Given client 'grim-client-001' is connected
        And client 'grim-client-002' is connected
        When client 'grim-client-001' sends the event 'Player Casts Spell' with the details:
        | Type | Player Casts Spell |
        | Spell Name | Fireball |
        | Target | NPC David |
        Then client 'grim-client-001' should have been sent the event:
        | Type | Player Casts Spell |
        | Spell Name | Fireball |
        | Target | NPC David |
        And client 'grim-client-002' should have been sent the event:
        | Type | Player Casts Spell |
        | Spell Name | Fireball |
        | Target | NPC David |
