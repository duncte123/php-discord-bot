package app

import java.util.concurrent.*
import net.dv8tion.jda.core.audio.*

class Echo : AudioReceiveHandler, AudioSendHandler {
    val queue = LinkedBlockingQueue<ByteArray>()

    override fun handleCombinedAudio(audio: CombinedAudio) {
        val data = audio.getAudioData(1.0)
        if (!data.all { it == 0.toByte() })
            queue.add(data)
    }

    override fun handleUserAudio(audio: UserAudio) {}

    override fun canProvide() = !queue.isEmpty()

    override fun provide20MsAudio() = queue.poll()

    override fun isOpus() = false

    override fun canReceiveUser() = false
    override fun canReceiveCombined() = true
}