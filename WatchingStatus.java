/eval import net.dv8tion.jda.core.managers.impl.*;
import org.json.JSONObject;
import net.dv8tion.jda.core.WebSocketCode;
JSONObject gameObj = new JSONObject();
gameObj.put("name", "Danny Phantom");
gameObj.put("type", 3);
JSONObject object = new JSONObject();
object.put("game", gameObj);
object.put("afk", jda.getPresence().idle);
object.put("status", jda.getPresence().status.getKey());
object.put("since", System.currentTimeMillis());
shardmanager.getShards().forEach({ it.getClient().send(new JSONObject()
            .put("d", object)
            .put("op", WebSocketCode.PRESENCE).toString())
});