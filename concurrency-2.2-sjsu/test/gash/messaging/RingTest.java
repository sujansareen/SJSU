package gash.messaging;

import gash.messaging.transports.MessageTransport;
import gash.messaging.transports.Ring;

import org.junit.AfterClass;
import org.junit.BeforeClass;
import org.junit.Test;

import java.util.ArrayList;

public class RingTest {

	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
	}

	@AfterClass
	public static void tearDownAfterClass() throws Exception {
	}

	@Test
	public void testClosedRing() throws Exception {
		// well formed (closed) ring
		MessageTransport r = new Ring(20);
		r.sendMessage(9, 3, "hello world");
		Thread.sleep(10000);
	}

	@Test
	public void testdUnknownNode() throws Exception {
		// sending a message to a node not in the ring
		MessageTransport r = new Ring(20);
		r.sendMessage(9, 30, "hello world");
		Thread.sleep(10000);
	}

	@Test
	public void testBrokenRing() throws Exception {
		// ring not closed
		MessageTransport r = new Ring(20);
		Node[] nodes = r.getNodes();
		// break the ring
		((RingNode) nodes[15]).setPrevious(null);
		((RingNode) nodes[14]).setNext(null);

		r.sendMessage(3, 17, "hello world");
		Thread.sleep(10000);
	}

	@Test
	public void testUnreachableNode() throws Exception {
		// the ring has been severed to create two segments
		MessageTransport r = new Ring(20);

		Node[] nodes = r.getNodes();

		// break the ring to isolate a segment of nodes
		((RingNode) nodes[15]).setPrevious(null);
		((RingNode) nodes[14]).setNext(null);
		((RingNode) nodes[19]).setPrevious(null);
		((RingNode) nodes[18]).setNext(null);

		r.sendMessage(3, 17, "hello world");
		Thread.sleep(10000);
	}
}
