package gash.socket.common;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import org.codehaus.jackson.map.ObjectMapper;

import gash.socket.data.Message;
import gash.socket.server.MessageHandler;
import gash.socket.server.MessageListener;

/**
 * construct data representations using JSON
 * 
 * @author gash1
 * 
 */
public class JsonBuilder implements MessageHandler {
	private ArrayList<MessageListener> listeners;

	public JsonBuilder() {
		listeners = new ArrayList<MessageListener>();
	}

	@Override
	public void process(byte[] msg, int len) {
		if (listeners.size() == 0)
			return;

		try {
			List<Message> msgs = JsonBuilder.decode(new String(msg, 0, len), Message.class);
			for (Message m : msgs) {
				for (MessageListener ml : listeners)
					ml.onMessage(m);
			}
		} catch (Exception e) {
			// TODO handle message error!
		}
	}

	@Override
	public void addListener(MessageListener listener) {
		if (!listeners.contains(listener))
			listeners.add(listener);
	}

	public static String encode(HashMap<String, String> data) {
		try {
			ObjectMapper mapper = new ObjectMapper();
			return mapper.writeValueAsString(data);
		} catch (Exception ex) {
			return null;
		}
	}

	public static String encode(Object data) {
		try {
			ObjectMapper mapper = new ObjectMapper();
			return mapper.writeValueAsString(data);
		} catch (Exception ex) {
			return null;
		}
	}

	public static <T> List<T> decode(String data, Class<T> theClass) {
		List<T> rtn = new ArrayList<T>();

		try {
			ObjectMapper mapper = new ObjectMapper();
			rtn.add(mapper.readValue(data.getBytes(), theClass));
		} catch (Exception ex) {
			ex.printStackTrace(); // TODO handle more gracefully!
		}

		return rtn;
	}
}
