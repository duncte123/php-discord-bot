// Please Do Not Throw Sausage Pizza Away!

gb.eval def role = guild.getRoleById("385916568447483915")
def count = guild.getMembersWithRoles(role).size()
return "${guild.name} has ${count} ${role.name}'s"

def getCount(String name) {
	def role = guild.getRolesByName(name, true).get(0)
	def count = guild.getMembersWithRoles(role).size()
	return "${guild.name} has ${count} ${role.name}'s"
}

gb.eval channel.getPinnedMessages().complete().size() + "/50 messages pinned in this channel"

def randomColour() {
	// https://api.alexflipnote.xyz/colour/random
	// https://api.alexflipnote.xyz/colour/(hex colour)
	me.duncte123.botCommons.web.WebUtils.ins.getJSONObject("http://www.colr.org/json/color/random").async {
		def color = it.getJSONArray("colors").getJSONObject(0)
		def name = color.getJSONArray("tags").getJSONObject(0).getString("name")
		def hex = "#${color.getString("hex")}"
    def image = "https://api.alexflipnote.xyz/colour/image/${color.getString("hex")}"
		MessageUtils.sendEmbed(event, EmbedUtils.defaultEmbed()
    .setThumbnail(image)
		.setColor(java.awt.Color.decode(hex)).setDescription("Color: $name\nhex: $hex").build())
	}
}

//skcheat.java
    public void onGuildMessageReactionAdd(GuildMessageReactionAddEvent event) {
        Guild guild = event.getGuild();
        User user = event.getUser();
        MessageChannel channel = event.getChannel();
        String msgId = event.getMessageId();
        String msgLink = "https://discordapp.com/channels/%s/%s/%s";
        if(!(guild.getIdLong() == 110373943822540800L && user.getIdLong() == 397898847906430976L)) {
            return;
        }
        System.out.println("Reaction added by " + user.getName());
        System.out.println("Link: " + String.format(msgLink, guild.getId(), channel.getId(), msgId));
        skhuntlink = String.format(msgLink, guild.getId(), channel.getId(), msgId);
    }