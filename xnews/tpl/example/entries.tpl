<li>[{{ p.comments.count }}
	]<a href="{{ news.url.full }}">{{ news.title|truncateHTML(15,'...') }}</a><br/> {{ news.dateStamp|date("m/d/Y G:i") }} {% if (pluginIsActive('uprofile')) %}
		<a href="{{ news.author.url }}">{{ news.author.name }}</a>{% endif %} {{ news.categories.masterText }} {% if (news.flags.canEdit) %}
	<img src="{{ skins_url }}/images/rewrite.gif">{% endif %}<br/></li><br/>
{% for image in news.embed.images %}<img src="{{ image }}"/>{% endfor %}