# Events test task

@TODO for future
- add DI container/autowiring

Examples and test inside `EventDispatcherTest.php`

If we will need to add a new event - we need to create one.
Then we can just dispatch it and it will be passed to `processEvent` method of services.
Then if logic for events differ - it should be handled by service logic.

To add a new broadcast channel - we need to implement interface and then just add it to `ChannelsManager`

`ChannelsManager` injects into dispatcher and used to broadcast on enabled channels.

We can easy control on which channels we want to broadcast event.