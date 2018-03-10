package gash.socket.common;

import java.io.StringReader;
import java.io.StringWriter;
import java.util.ArrayList;
import java.util.List;

import javax.xml.bind.JAXBContext;

import gash.socket.data.Message;
import gash.socket.server.MessageHandler;
import gash.socket.server.MessageListener;

public class XmlBuilder implements MessageHandler {
	private ArrayList<MessageListener> listeners;

	public XmlBuilder() {
		listeners = new ArrayList<MessageListener>();
	}

	@Override
	public void process(byte[] msg, int len) {
		if (listeners.size() == 0)
			return;

		try {
			List<Message> msgs = XmlBuilder.decode(msg, len);
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

	public static String encode(Message data) {
		String rtn = null;

		try {
			JAXBContext jaxbContext = JAXBContext.newInstance(Message.class);
			StringWriter writer = new StringWriter();
			jaxbContext.createMarshaller().marshal(data, writer);
			rtn = writer.toString();
		} catch (Exception ex) {
			ex.printStackTrace();
		}

		return rtn;
	}

	public static List<Message> decode(byte[] msg, int len) {
		List<Message> rtn = new ArrayList<Message>();

		try {
			JAXBContext jaxbContext = JAXBContext.newInstance(Message.class);
			StringReader src = new StringReader(new String(msg, 0, len));
			rtn.add((Message) jaxbContext.createUnmarshaller().unmarshal(src));
		} catch (Exception ex) {
			ex.printStackTrace();
		}

		return rtn;
	}

}
