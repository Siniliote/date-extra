Twig Date Extension
===================

The *Date* extension provides the `time_diff` filter.

`time_diff`
-------------

Use the `time_diff` filter to render the difference between a date and now.

```twig
{{ post.published_at|time_diff }}
```

The example above will output a string like `4 seconds ago`  or `in 1 month`,
depending on the filtered date.

## Arguments

* `date`: The date for calculate the difference from now. Can be a string
  or a DateTime instance.

* `now`: The date that should be used as now. Can be a string or
  a DateTime instance. Do not set this argument to use current date.

## Translation

To get a translatable output, give a `Symfony\Contracts\Translation\TranslatorInterface`
as constructor argument. The returned string is formatted as `diff.ago.XXX`
or `diff.in.XXX` where `XXX` can be any valid unit: second, minute, hour, day, month, year.