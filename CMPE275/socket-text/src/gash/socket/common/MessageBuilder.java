package gash.socket.common;

import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import gash.socket.data.Message;
import gash.socket.server.MessageHandler;
import gash.socket.server.MessageListener;

/**
 * the builder to construct commands that both the client (BasicSocketClient)
 * and server (BasicSocketServer) understands/accepts
 * 
 * @author gash
 * 
 */
public class MessageBuilder implements MessageHandler {
	public enum MessageType {
		ping, join, leave, msg, list
	}

	protected static final String sMsgMarkerStart = "[";
	protected static final String sMsgMarkerEnd = "]";
	protected static final String sHeaderMarker = "!h!";
	protected static final String sBodyMarker = "!b!";

	protected static final String sMsgMarkerStartRX = "\\[";

	private ArrayList<MessageListener> listeners;
	private String incompleteBuffer;
	private boolean debug = false;

	public MessageBuilder() {
		listeners = new ArrayList<MessageListener>();
	}

	@Override
	public void process(byte[] msg, int len) {
		// System.out.println("[debug process]: " + msg);

		if (listeners.size() == 0)
			return;

		try {
			List<Message> msgs = decode(new String(msg, 0, len));
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

	public String encode(MessageType type, String source, String body, Date received) {
		String payload = null;
		if (body != null)
			payload = body.trim();

		DecimalFormat fmt = new DecimalFormat("0000");
		StringBuilder sb = new StringBuilder();
		sb.append(sHeaderMarker);
		sb.append(type);
		sb.append(',');
		sb.append(System.currentTimeMillis());
		sb.append(',');
		if (received != null)
			sb.append(received);
		sb.append(',');
		if (source != null)
			sb.append(source.trim());
		sb.append(',');
		if (payload == null) {
			sb.append(0);
			sb.append(sBodyMarker);
		} else {
			sb.append(fmt.format(payload.length()));
			sb.append(sBodyMarker);
			if (payload != null)
				sb.append(payload);
		}

		String msg = sb.toString();

		sb = new StringBuilder();
		sb.append(sMsgMarkerStart);

		sb.append(fmt.format(msg.length()));
		sb.append(msg);
		sb.append(sMsgMarkerEnd);

		return sb.toString();
	}

	private List<Message> decode(String raw) throws Exception {
		if (raw == null || raw.length() == 0)
			return null;

		if (incompleteBuffer != null) {
			raw = incompleteBuffer + raw;
		}

		String[] msgs = raw.split(sMsgMarkerStartRX);
		ArrayList<Message> rtn = new ArrayList<Message>();
		for (String m : msgs) {
			// System.out.println("decoding: '" + m + "'");
			if (m.length() == 0)
				continue;

			// incomplete message
			if (!m.endsWith(sMsgMarkerEnd)) {
				incompleteBuffer = sMsgMarkerStart + m;
				break;
			} else
				incompleteBuffer = null;

			// TODO use slf4j
			if (debug)
				System.out.println("--> m (size = " + m.length() + "): " + m);

			String[] hdr = m.split(sHeaderMarker);
			if (hdr.length != 2)
				throw new RuntimeException("Unexpected message format");
			
			int size = Integer.parseInt(hdr[0]);
			// TODO validate message length to size
			
			String t = hdr[1];
			String[] bd = t.split(sBodyMarker);
			if (bd.length != 2)
				throw new RuntimeException("Unexpected message format (2)");

			String body = bd[1].substring(0, bd[1].length() - 1);
			String header = bd[0];

			String[] hparts = header.split(",");
			if (hparts.length != 5)
				throw new RuntimeException("Unexpected message format (3)");

			Message bo = new Message();
			bo.setType(MessageType.valueOf(hparts[0]));

			if (hparts[1].length() > 0)
				bo.setReceived(new Date(Long.parseLong(hparts[1])));

			// entry 2 is not used

			bo.setSource(hparts[3]);

			int bodySize = Integer.parseInt(hparts[4]);
			if (bodySize != body.length())
				throw new RuntimeException("Body does not match checksum");

			bo.setPayload(body);

			// TODO use slf4j
			if (debug) {
				System.out.println("--> h: " + header);
				System.out.println("--> b: " + body);
			}

			rtn.add(bo);
		}

		return rtn;
	}

	public void reset() {
		incompleteBuffer = null;
	}

	public boolean isComplete() {
		return (incompleteBuffer == null);
	}

}
