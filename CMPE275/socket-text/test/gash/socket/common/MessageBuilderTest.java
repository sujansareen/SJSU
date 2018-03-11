package gash.socket.common;

import java.text.DecimalFormat;

import org.junit.Assert;
import org.junit.Test;

import gash.socket.common.MessageBuilder.MessageType;
import gash.socket.data.Message;
import gash.socket.server.MessageListener;

public class MessageBuilderTest {

	@Test
	public void testFormat() throws Exception {
		DecimalFormat fmt = new DecimalFormat("0000");
		System.out.println("s: " + fmt.format(10.0));
	}

	@Test
	public void testEncodingOne() throws Exception {
		MessageBuilder builder = new MessageBuilder();

		String s = builder.encode(MessageType.join, "testSrc", "hello world", null);
		System.out.println("msg: " + s);

		MessageListener listen = new MessageListener() {
			@Override
			public void onMessage(Message msg) {
				Assert.assertNotNull(msg);
				System.out.println("msg type:" + msg.getType());
				System.out.println("source: " + msg.getSource());
				System.out.println("date: " + msg.getReceived());
				System.out.println("payload: " + msg.getPayload() + "\n");
			}
		};

		builder.addListener(listen);
		builder.process(s.getBytes(), s.length());

		// note the listener is envoked sync., what happens if it is async?
		System.out.println("\nis complete: " + builder.isComplete());
	}

	@Test
	public void testEncodingTwo() throws Exception {
		MessageBuilder builder = new MessageBuilder();

		String s = builder.encode(MessageType.join, "testSrc", null, null)
				+ builder.encode(MessageType.msg, "testSrc", "goodbye world", null);
		System.out.println("msg: " + s);

		MessageListener listen = new MessageListener() {
			@Override
			public void onMessage(Message msg) {
				Assert.assertNotNull(msg);
				System.out.println("msg type:" + msg.getType());
				System.out.println("source: " + msg.getSource());
				System.out.println("date: " + msg.getReceived());
				System.out.println("payload: " + msg.getPayload() + "\n");
			}
		};

		builder.addListener(listen);
		builder.process(s.getBytes(), s.length());

		System.out.println("\nis complete: " + builder.isComplete());
	}

	@Test
	public void testEncodingPartial() throws Exception {
		MessageBuilder builder = new MessageBuilder();

		String s = builder.encode(MessageType.join, "testSrc", null, null)
				+ builder.encode(MessageType.msg, "testSrc", "goodbye world", null).substring(0, 20);
		System.out.println("msg: " + s);

		MessageListener listen = new MessageListener() {
			@Override
			public void onMessage(Message msg) {
				Assert.assertNotNull(msg);
				System.out.println("msg type:" + msg.getType());
				System.out.println("source: " + msg.getSource());
				System.out.println("date: " + msg.getReceived());
				System.out.println("payload: " + msg.getPayload() + "\n");
			}
		};

		builder.addListener(listen);
		builder.process(s.getBytes(), s.length());

		System.out.println("\nis complete: " + builder.isComplete());
	}

	/**
	 * a partial message is received, ensure we buffer the remained for the next
	 * decoding
	 * 
	 * @throws Exception
	 */
	@Test
	public void testEncodingPartialComplete() throws Exception {
		MessageBuilder builder = new MessageBuilder();

		String s2 = builder.encode(MessageType.msg, "testSrc", "goodbye world", null);

		String s = builder.encode(MessageType.join, "testSrc", null, null) + s2.substring(0, 20);
		System.out.println("raw: " + s);

		MessageListener listen = new MessageListener() {
			@Override
			public void onMessage(Message msg) {
				Assert.assertNotNull(msg);
				System.out.println("msg type:" + msg.getType());
				System.out.println("source: " + msg.getSource());
				System.out.println("date: " + msg.getReceived());
				System.out.println("payload: " + msg.getPayload() + "\n");
			}
		};

		builder.addListener(listen);
		builder.process(s.getBytes(), s.length());

		System.out.println("\nis complete: " + builder.isComplete());

		// now process the rest of message 2
		builder.process(s2.substring(20).getBytes(), s2.length());
		System.out.println("\nis complete: " + builder.isComplete());

	}
}
