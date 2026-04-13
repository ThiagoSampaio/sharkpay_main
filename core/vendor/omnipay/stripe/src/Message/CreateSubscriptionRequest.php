evealed.
  ///
  /// Also used by [RenderTwoDimensionalViewport.showInViewport] for each
  /// horizontal and vertical [Axis].
  ///
  /// If the target [RenderObject] is already fully visible, this will return
  /// null.
  static RevealedOffset? clampOffset({
    required RevealedOffset leadingEdgeOffset,
    required RevealedOffset trailingEdgeOffset,
    required double currentOffset,
  }) {
    //           scrollOffset
    //                       0 +---------+
    //                         |         |
    //                       _ |         |
    //    viewport position |  |         |
    // with `descendant` at |  |         | _
    //        trailing edge |_ | xxxxxxx |  | viewport position
    //                         |         |  | with `descendant` at
    //                         |         | _| leading edge
    //                         |         |
    //                     800 +---------+
    //
    // `trailingEdgeOffset`: Distance from scrollOffset 0 to the start of the
    //                       viewport on the left in image above.
    // `leadingEdgeOffset`: Distance from scrollOffset 0 to the start of the
    //                      viewport on the right in image above.
    //
    // The viewport position on the left is achieved by setting `offset.pixels`
    // to `trailingEdgeOffset`, the one on the right by setting it to
    // `leadingEdgeOffset`.
    final bool inverted = leadingEdgeOffset.offset < trailingEdgeOffset.offset;
    final RevealedOffset smaller;
    final RevealedOffset larger;
    (smaller, larger) =
        inverted
            ? (leadingEdgeOffset, trailingEdgeOffset)
            : (trailingEdgeOffset, leadingEdgeOffset);
    if (currentOffset > larger.offset) {
      return larger;
    } else if (currentOffset < smaller.offset) {
      return smaller;
    } else {
      return null;
    }
  }

  @override
  String toString() {
    return '${objectRuntimeType(this, 'RevealedOffset')}(offset: $offset, rect: $rect)';
  }
}

/// A base class for render objects that are bigger on the inside.
///
/// This render object provides the shared code for render objects that host
/// [RenderSliver] render objects inside a [RenderBo