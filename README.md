## IP Exception
When you are in the process of developing a website, you want to make sure that the front-end of the website can not be reached by anyone (since it's not released yet). MODX offers a great system setting (site_status) to make the front-end of your website unreachable, so that's not a problem, right?

But what if you want somebody's opinion during the development process? The client's maybe? You would have to make the website public for a short time, with the risk that literally anyone can visit it during that short period of time.

To work around this problem, [Oetzie][1] introduced IP Exception: a free to use MODX Extra. As the name already suggests, this Extra lets you create exceptions based on IP addresses, considering website access. When you want somebody's opinion about the front-end of your website, you can add their IP address to IP Exception. This way, you can leave the front-end of your website unreachable for the general audience, but make it reachable for the inserted IP addresses!

For other cases: IP Exception also work the other way around: you can use it to block IP addresses from your website too.

## Features
* IP Exception lets you import and export IP addresses.
* IP Exception not only allows you to grant access to certain IP addresses, it also allows you to block certain IP addresses.
* IP Exception offers you a button to automatically insert your own IP address (you don't have to type it in!).
* IP Exception lets you select the website context(s) where the exception should be applied to.
* For maintaining reasons: IP Exception allows you to filter your exceptions based on both context and type, also it has a search function.

## Workflow
1. Open up the IP Exception Extra from your navigation.
2. Click the big green button to create a new exception.
3. Fill in the fields.
4. Save it. Done!

**Tip:** go to system settings and search for site_status, with this option you can make your website unreachable for the main audience (which you can make exceptions from using IP Exception).

## Requirements
* MODX version 2.5.0 or newer has to be installed.

## Bugs and feature requests
We greatly value your feedback, feature requests and bug reports. Please issue them on [GitHub][2].

[1]: http://www.oetzie.nl
[2]: https://github.com/Oetzie/ErrorLog/issues/new
